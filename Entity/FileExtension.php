<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="cl_file_extension",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="extension_UNIQUE", columns={"extension"})}
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "image"="Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage",
 *     "pdf"="Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf"
 * }
 * )
 */
class FileExtension
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=10, nullable=false, name="extension")
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, name="mime_type")
     */
    private $mimeType;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return self
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get mimeType.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set mimeType.
     *
     * @param string $mimeType
     *
     * @return self
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }
}
