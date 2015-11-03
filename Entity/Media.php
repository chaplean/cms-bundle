<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_media", uniqueConstraints={@ORM\UniqueConstraint(name="path_UNIQUE", columns={"path"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap(
 *     {"image"="Chaplean\Bundle\CmsBundle\Entity\MediaImage","pdf"="Chaplean\Bundle\CmsBundle\Entity\MediaPdf"}
 * )
 */
abstract class Media
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
     * @ORM\Column(type="string", length=200, nullable=false, name="path")
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="file_name")
     */
    private $fileName;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="file_weight", options={"unsigned":true})
     */
    private $fileWeight;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_updated")
     */
    private $dateUpdated;

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
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get fileName.
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileName.
     *
     * @param string $fileName
     *
     * @return self
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileWeight.
     *
     * @return integer
     */
    public function getFileWeight()
    {
        return $this->fileWeight;
    }

    /**
     * Set fileWeight.
     *
     * @param integer $fileWeight
     *
     * @return self
     */
    public function setFileWeight($fileWeight)
    {
        $this->fileWeight = $fileWeight;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return self
     */
    public function setDateAdd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get dateUpdated.
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set dateUpdated.
     *
     * @param \DateTime $dateUpdated
     *
     * @return self
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }
}
