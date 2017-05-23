<?php

namespace Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Entity\FileExtension;
use Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage;
use Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf;
use Chaplean\Bundle\CmsBundle\Entity\Media;
use Chaplean\Bundle\CmsBundle\Entity\MediaImage;
use Chaplean\Bundle\CmsBundle\Entity\MediaPdf;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * MediaUtility.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class MediaUtility
{
    /** @var  UploadedFile $uploadedFile */
    private $uploadedFile;

    /** @var Media $existingMedia */
    private $existingMedia;

    /** @var EntityManager $em */
    private $em;

    /** @var Logger $logger */
    private $logger;

    /** @var string $publicDir */
    private $publicDir;

    /** @var bool|array $mediaConfig */
    private $mediaConfig;

    /**
     * MediaUtility constructor.
     *
     * @param Registry $doctrine
     * @param Logger   $logger
     * @param string   $rootDir
     * @param string   $mediaConfig
     */
    public function __construct(Registry $doctrine, Logger $logger, $rootDir, $mediaConfig)
    {
        $this->em = $doctrine->getManager();
        $this->logger = $logger;
        $this->publicDir = $rootDir . '/../web';
        $this->mediaConfig = $mediaConfig;
    }

    /**
     * Set uploadedFile.
     *
     * @param UploadedFile $file
     *
     * @return MediaUtility
     */
    public function setFile(UploadedFile $file)
    {
        $this->uploadedFile = $file;

        return $this;
    }

    /**
     * Set existingMedia.
     *
     * @param Media $media
     *
     * @return MediaUtility
     */
    public function setMedia(Media $media)
    {
        $this->existingMedia = $media;

        return $this;
    }

    /**
     * Find the file extension corresponding to the uploaded file
     *
     * @return FileExtension|null
     */
    public function getUploadedFileExtension()
    {
        $mime = $this->uploadedFile->getMimeType();

        /** @var FileExtension $fileExtension */
        $fileExtension = $this->em->getRepository('ChapleanCmsBundle:FileExtension')
            ->findOneBy(array('mimeType' => $mime));

        return $fileExtension;
    }

    /**
     * Insert a media in DB corresponding to the uploaded file and move the file to its correct place
     *
     * @param string $mediaDirectory
     *
     * @return Media|null
     */
    public function createMedia($mediaDirectory = 'default')
    {
        $fileExtension = $this->getUploadedFileExtension();

        $this->existingMedia = null;

        if ($fileExtension instanceof FileExtensionImage) {
            $this->existingMedia = new MediaImage();
            $this->existingMedia->setTitle('');
            $this->existingMedia->setAlternativeTitle('');

            $this->determineImageSize();
        } elseif ($fileExtension instanceof FileExtensionPdf) {
            $this->existingMedia = new MediaPdf();
            $this->existingMedia->setTitle('');
        }

        if ($this->existingMedia === null || is_array($this->mediaConfig)) {
            return null;
        }

        $fileDir = '/medias/' . $mediaDirectory . '/';
        $fileName = md5(uniqid());

        $this->existingMedia->setPath($fileDir . $fileName);
        $this->existingMedia->setFileName($this->uploadedFile->getClientOriginalName());
        $this->existingMedia->setFileWeight($this->uploadedFile->getSize() / 1000);
        $this->existingMedia->setDateAdd(new \DateTime('now'));
        $this->existingMedia->setDateUpdated(new \DateTime('now'));
        $this->existingMedia->setExtension($fileExtension);

        $this->em->persist($this->existingMedia);

        return $this->moveFile($fileDir, $fileName, true);
    }

    /**
     * Update the existing media DB object and replace the previous file with the uploaded one
     *
     * @return Media|null
     */
    public function updateMedia()
    {
        $fileExtension = $this->getUploadedFileExtension();

        $var = get_class($fileExtension);

        if ($this->existingMedia->getExtension() instanceof $var) {
            if ($this->existingMedia instanceof MediaImage) {
                $this->determineImageSize();
            }

            $this->existingMedia->setFileName($this->uploadedFile->getClientOriginalName());
            $this->existingMedia->setDateUpdated(new \DateTime('now'));
            $this->existingMedia->setExtension($fileExtension);

            $this->em->persist($this->existingMedia);

            $pathSplited = explode('/', $this->existingMedia->getPath());
            $fileName = array_pop($pathSplited);
            $fileDir = implode('/', $pathSplited);

            return $this->moveFile($fileDir, $fileName);
        } else {
            return null;
        }
    }

    /**
     * @return integer
     */
    public function deleteMedia()
    {
        $result = true;

        if (!file_exists($this->publicDir . $this->existingMedia->getPath())) {
            $result = true;
        } elseif (!unlink($this->publicDir . $this->existingMedia->getPath())) {
            return false;
        }

        $this->em->remove($this->existingMedia);

        return $result;
    }

    /**
     * Determine the dimension of an image
     *
     * @throws \Exception
     * @return void
     */
    private function determineImageSize()
    {
        $imageSize = getimagesize($this->uploadedFile->getPathname());

        if (!$imageSize) {
            throw new FileException(sprintf('Impossible to get image size for %s', $this->uploadedFile->getPathname()));
        }

        $this->existingMedia->setWidth($imageSize[0]);
        $this->existingMedia->setHeight($imageSize[1]);
    }

    /**
     * Move the uploaded file on the server
     *
     * @param string  $fileDir
     * @param string  $fileName
     * @param boolean $deleteOnFail
     *
     * @return Media|null
     */
    private function moveFile($fileDir, $fileName, $deleteOnFail = false)
    {
        try {
            $this->uploadedFile->move($this->publicDir . $fileDir, $fileName);
        } catch (FileException $e) {
            $this->logger->error(sprintf('[ERROR] %s : %s', __FUNCTION__, $e->getMessage()));
            if ($deleteOnFail) {
                $this->em->remove($this->existingMedia);
            }

            return null;
        }

        return $this->existingMedia;
    }
}
