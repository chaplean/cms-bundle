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
    /** @var FileExtension $newFileExtension */
    private $newFileExtension;

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
     * @param string   $chapleanCms
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
        $this->newFileExtension = $this->em->getRepository('ChapleanCmsBundle:FileExtension')
                                           ->findOneBy(array('mimeType' => $mime));
        if (!$this->newFileExtension) {
            return null;
        }

        return $this->newFileExtension;
    }

    /**
     * Insert a media in DB corresponding to the uploaded file and move the file to its correct place
     *
     * @return Media|null
     */
    public function createMedia()
    {
        if (!$this->newFileExtension) {
            $this->getUploadedFileExtension();
        }

        $this->existingMedia = null;
        $type = '';
        if ($this->newFileExtension instanceof FileExtensionImage) {
            $type = 'image';
            $this->existingMedia = new MediaImage();
            $this->existingMedia->setTitle('');
            $this->existingMedia->setAlternativeTitle('');
            $this->setImageSize();
        } elseif ($this->newFileExtension instanceof FileExtensionPdf) {
            $type = 'pdf';
            $this->existingMedia = new MediaPdf();
            $this->existingMedia->setTitle('');
        }

        if (!$this->existingMedia || (is_array($this->mediaConfig) && !in_array($type, $this->mediaConfig))) {
            return null;
        }

        $fileDir = '/medias/';
        $fileName = md5(uniqid());
        $this->existingMedia->setPath($fileDir . $fileName);
        $this->existingMedia->setFileName($this->uploadedFile->getClientOriginalName());
        $this->existingMedia->setFileWeight($this->uploadedFile->getSize() / 1000);
        $this->existingMedia->setDateAdd(new \DateTime('now'));
        $this->existingMedia->setDateUpdated(new \DateTime('now'));
        $this->existingMedia->setExtension($this->newFileExtension);

        $this->em->persist($this->existingMedia);
        $this->em->flush();

        return $this->moveFile($fileDir, $fileName, true);
    }

    /**
     * Update the existing media DB object and replace the previous file with the uploaded one
     *
     * @return Media|null
     */
    public function updateMedia()
    {
        if (!$this->newFileExtension) {
            $this->getUploadedFileExtension();
        }

        $var = get_class($this->newFileExtension);
        if ($this->existingMedia->getExtension() instanceof $var) {
            if ($this->existingMedia instanceof MediaImage) {
                $this->setImageSize();
            }

            $this->existingMedia->setFileName($this->uploadedFile->getClientOriginalName());
            $this->existingMedia->setDateUpdated(new \DateTime('now'));
            $this->existingMedia->setExtension($this->newFileExtension);

            $this->em->persist($this->existingMedia);
            $this->em->flush();

            $pathSplited = explode('/', $this->existingMedia->getPath());
            $fileName = array_pop($pathSplited);
            $fileDir = implode('/', $pathSplited);

            return $this->moveFile($fileDir, $fileName);
        } else {
            return null;
        }
    }

    public function deleteMedia()
    {
        if (!unlink($this->publicDir . $this->existingMedia->getPath())) {
            return false;
        }
        $this->em->remove($this->existingMedia);
        $this->em->flush();

        return true;
    }

    /**
     * Determine the dimension of an image
     *
     * @return void
     */
    private function setImageSize()
    {
        list($width, $height) = getimagesize($this->uploadedFile->getPathname());
        $this->existingMedia->setWidth($width);
        $this->existingMedia->setHeight($height);
    }

    /**
     * Move the uploaded file on the server
     *
     * @param $fileDir
     * @param $fileName
     * @param $deleteOnFail
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
                $this->em->flush();
            }

            return null;
        }

        return $this->existingMedia;
    }
}