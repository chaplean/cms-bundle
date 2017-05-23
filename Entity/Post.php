<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

/**
 * @ORM\Entity(repositoryClass="Chaplean\Bundle\CmsBundle\Repository\PostRepository")
 * @ORM\Table(name="cl_post")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="category", type="string")
 * @ORM\DiscriminatorMap({
 *     "news":"Chaplean\Bundle\CmsBundle\Entity\Post",
 *     "video":"Chaplean\Bundle\CmsBundle\Entity\PostVideo",
 *     "testimonial":"Chaplean\Bundle\CmsBundle\Entity\PostTestimonial",
 *     "zoom":"Chaplean\Bundle\CmsBundle\Entity\PostZoom"
 * })
 */
class Post
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"post_id", "post_all"})
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     *
     * @JMS\Groups({"post_date_add", "post_all"})
     */
    protected $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_update")
     *
     * @JMS\Groups({"post_date_update", "post_all"})
     */
    protected $dateUpdate;

    /**
     * @var Publication
     *
     * @ORM\OneToOne(targetEntity="Chaplean\Bundle\CmsBundle\Entity\Publication")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id", nullable=false, unique=true)
     *
     * @JMS\Groups({"post_publication", "post_all"})
     */
    private $publication;

    /**
     * @var Page
     *
     * @ORM\Embedded(class="Chaplean\Bundle\CmsBundle\Entity\Page")
     *
     * @JMS\Groups({"post_page", "post_all"})
     */
    protected $page;

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

    /**
     * Get page.
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page.
     *
     * @param Page $page
     *
     * @return self
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("category")
     * @JMS\Groups({"post_category", "post_all"})
     *
     * @return string
     */
    public function getInstanceOf()
    {
        switch (true) {
            case $this instanceof PostVideo:
                return 'video';
            case $this instanceof PostZoom:
                return 'zoom';
            case $this instanceof PostTestimonial:
                return 'testimonial';
            case $this instanceof Post:
                return 'news';
            default:
                throw new UndefinedOptionsException(sprintf('Undefined subclass %s', get_class($this)));
        }
    }
}
