<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_post")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="category", type="string")
 * @ORM\DiscriminatorMap(
 *     {
 *     "news"="Chaplean\Bundle\CmsBundle\Entity\Post",
 *     "video"="Chaplean\Bundle\CmsBundle\Entity\PostVideo",
 *     "testimonial"="Chaplean\Bundle\CmsBundle\Entity\PostTestimonial",
 *     "zoom"="Chaplean\Bundle\CmsBundle\Entity\PostZoom"
 * }
 * )
 */
class Post
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_update")
     */
    private $dateUpdate;

    /**
     * @var Page
     *
     * @ORM\Embedded(class="Chaplean\Bundle\CmsBundle\Entity\Page")
     */
    private $page;

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
}
