<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_block", uniqueConstraints={@ORM\UniqueConstraint(name="name_UNIQUE", columns={"name"})})
 */
class Block
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"block_id"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=50, nullable=false)
     *
     * @JMS\Groups({"block_name"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @JMS\Groups({"block_content"})
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @JMS\Groups({"block_date_add"})
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @JMS\Groups({"block_date_update"})
     */
    private $dateUpdate;

    /**
     * @var Publication
     *
     * @ORM\OneToOne(targetEntity="Publication")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id", nullable=false, unique=true)
     *
     * @JMS\Groups({"block_publication"})
     */
    private $publication;

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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

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
     * Get dateUpdate.
     *
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set dateUpdate.
     *
     * @param \DateTime $dateUpdate
     *
     * @return self
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get publication.
     *
     * @return Publication
     */
    public function getPublication()
    {
        return $this->publication;
    }

    /**
     * Set publication.
     *
     * @param Publication $publication
     *
     * @return self
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }
}