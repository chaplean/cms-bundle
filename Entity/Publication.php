<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="cl_publication",
 *     indexes={
 *         @ORM\Index(name="publication_date_publication_begin_INDEX", columns={"date_publication_begin"}),
 *         @ORM\Index(name="publication_date_publication_end_INDEX", columns={"date_publication_end"}),
 *         @ORM\Index(name="publication_status_INDEX", columns={"status"}),
 *         @ORM\Index(name="publication_is_highlighted_INDEX", columns={"is_highlighted"})
 *     }
 * )
 */
class Publication
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"publication_id", "publication_all"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_publication_begin")
     *
     * @JMS\Groups({"publication_date_publication_begin", "publication_all"})
     */
    private $datePublicationBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_publication_end")
     *
     * @JMS\Groups({"publication_date_publication_end", "publication_all"})
     */
    private $datePublicationEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false, name="is_highlighted", options={"default":0})
     *
     * @JMS\Groups({"publication_is_highlighted", "publication_all"})
     */
    private $isHighlighted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     *
     * @JMS\Groups({"publication_date_add", "publication_all"})
     */
    private $dateAdd;

    /**
     * @var PublicationStatus
     *
     * @ORM\ManyToOne(targetEntity="Chaplean\Bundle\CmsBundle\Entity\PublicationStatus", inversedBy="publications")
     * @ORM\JoinColumn(name="status", referencedColumnName="id", nullable=false)
     *
     * @JMS\Groups({"publication_status", "publication_all"})
     */
    private $status;

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
     * Get datePublicationBegin.
     *
     * @return \DateTime
     */
    public function getDatePublicationBegin()
    {
        return $this->datePublicationBegin;
    }

    /**
     * Set datePublicationBegin.
     *
     * @param \DateTime $datePublicationBegin
     *
     * @return self
     */
    public function setDatePublicationBegin($datePublicationBegin)
    {
        $this->datePublicationBegin = $datePublicationBegin;

        return $this;
    }

    /**
     * Get datePublicationEnd.
     *
     * @return \DateTime
     */
    public function getDatePublicationEnd()
    {
        return $this->datePublicationEnd;
    }

    /**
     * Set datePublicationEnd.
     *
     * @param \DateTime $datePublicationEnd
     *
     * @return self
     */
    public function setDatePublicationEnd($datePublicationEnd)
    {
        $this->datePublicationEnd = $datePublicationEnd;

        return $this;
    }

    /**
     * Get isHighlighted.
     *
     * @return boolean
     */
    public function isIsHighlighted()
    {
        return $this->isHighlighted;
    }

    /**
     * Set isHighlighted.
     *
     * @param boolean $isHighlighted
     *
     * @return self
     */
    public function setIsHighlighted($isHighlighted)
    {
        $this->isHighlighted = $isHighlighted;

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
     * Get status.
     *
     * @return PublicationStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param PublicationStatus $status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
