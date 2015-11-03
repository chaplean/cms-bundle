<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_file_extension_image")
 */
class FileExtensionImage extends \Chaplean\Bundle\CmsBundle\Entity\FileExtension
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chaplean\Bundle\CmsBundle\Entity\MediaImage", mappedBy="extension")
     */
    private $images;

    /**
     * Get images.
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images.
     *
     * @param ArrayCollection $images
     *
     * @return self
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Add image
     *
     * @param MediaImage $image
     *
     * @return self
     */
    public function addImage(MediaImage $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param MediaImage $image
     *
     * @return void
     */
    public function removeImage(MediaImage $image)
    {
        $this->images->removeElement($image);
    }
}
