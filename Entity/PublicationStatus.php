<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="cl_publication_status",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="publication_status_keyname_UNIQUE", columns={"keyname"}),
 *         @ORM\UniqueConstraint(name="publication_status_position_UNIQUE", columns={"position"})
 *     }
 * )
 */
class PublicationStatus
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"publication_status_id", "publication_status_all"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=50, nullable=false, name="keyname")
     *
     * @JMS\Groups({"publication_status_keyname", "publication_status_all"})
     */
    private $keyname;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", unique=true, nullable=false, name="position", options={"unsigned":true})
     *
     * @JMS\Groups({"publication_status_position", "publication_status_all"})
     */
    private $position;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chaplean\Bundle\CmsBundle\Entity\Publication", mappedBy="status")
     *
     * @JMS\MaxDepth(depth=1)
     * @JMS\Groups({"publication_status_publications", "publication_status_all"})
     */
    private $publications;

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
     * Get keyname.
     *
     * @return string
     */
    public function getKeyname()
    {
        return $this->keyname;
    }

    /**
     * Set keyname.
     *
     * @param string $keyname
     *
     * @return self
     */
    public function setKeyname($keyname)
    {
        $this->keyname = $keyname;

        return $this;
    }

    /**
     * Get position.
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param integer $position
     *
     * @return self
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get publications.
     *
     * @return ArrayCollection
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * Set publications.
     *
     * @param ArrayCollection $publications
     *
     * @return self
     */
    public function setPublications(ArrayCollection $publications)
    {
        $this->publications = $publications;

        return $this;
    }

    /**
     * Add publication
     *
     * @param Publication $publication
     *
     * @return self
     */
    public function addPublication(Publication $publication)
    {
        $this->publications[] = $publication;

        return $this;
    }

    /**
     * Remove publication
     *
     * @param Publication $publication
     *
     * @return void
     */
    public function removePublication(Publication $publication)
    {
        $this->publications->removeElement($publication);
    }
}
