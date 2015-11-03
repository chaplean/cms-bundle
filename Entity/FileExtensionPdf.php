<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_file_extension_pdf")
 */
class FileExtensionPdf extends FileExtension
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chaplean\Bundle\CmsBundle\Entity\MediaPdf", mappedBy="extension")
     */
    private $medias;

    /**
     * Get medias.
     *
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set medias.
     *
     * @param ArrayCollection $medias
     *
     * @return self
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;

        return $this;
    }

    /**
     * Add media
     *
     * @param MediaPdf $media
     *
     * @return self
     */
    public function addMedia(MediaPdf $media)
    {
        $this->medias[] = $media;

        return $this;
    }

    /**
     * Remove media
     *
     * @param MediaPdf $media
     *
     * @return void
     */
    public function removeMedia(MediaPdf $media)
    {
        $this->medias->removeElement($media);
    }
}
