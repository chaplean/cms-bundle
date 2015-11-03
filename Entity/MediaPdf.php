<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_media_pdf")
 */
class MediaPdf extends \Chaplean\Bundle\CmsBundle\Entity\Media
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="title")
     */
    private $title;

    /**
     * @var FileExtensionPdf
     *
     * @ORM\ManyToOne(targetEntity="Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf", inversedBy="medias")
     * @ORM\JoinColumn(name="extension", referencedColumnName="id", nullable=false)
     */
    private $extension;

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
     * Get extension.
     *
     * @return FileExtensionPdf
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension.
     *
     * @param FileExtensionPdf $extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }
}
