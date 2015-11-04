<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as JMS;

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
abstract class FileExtension
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"file_extension_id"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=10, nullable=false, name="extension")
     *
     * @JMS\Groups({"file_extension_extension"})
     */
    protected $extension;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, name="mime_type")
     *
     * @JMS\Groups({"file_extension_mime_type"})
     */
    protected $mimeType;

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
