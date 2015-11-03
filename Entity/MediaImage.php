<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="cl_media_image",
 *     indexes={@ORM\Index(name="width_INDEX", columns={"width"}),@ORM\Index(name="height_INDEX", columns={"height"})}
 * )
 */
class MediaImage extends \Chaplean\Bundle\CmsBundle\Entity\Media
{
    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false, name="width", options={"unsigned":true})
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false, name="height", options={"unsigned":true})
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="title")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="alternative_title")
     */
    private $alternativeTitle;

    /**
     * @var FileExtensionImage
     *
     * @ORM\ManyToOne(targetEntity="Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage", inversedBy="images")
     * @ORM\JoinColumn(name="extension", referencedColumnName="id", nullable=false)
     */
    private $extension;

    /**
     * Get width.
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set width.
     *
     * @param integer $width
     *
     * @return self
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get height.
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set height.
     *
     * @param integer $height
     *
     * @return self
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get alternativeTitle.
     *
     * @return string
     */
    public function getAlternativeTitle()
    {
        return $this->alternativeTitle;
    }

    /**
     * Set alternativeTitle.
     *
     * @param string $alternativeTitle
     *
     * @return self
     */
    public function setAlternativeTitle($alternativeTitle)
    {
        $this->alternativeTitle = $alternativeTitle;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return FileExtensionImage
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension.
     *
     * @param FileExtensionImage $extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
}
