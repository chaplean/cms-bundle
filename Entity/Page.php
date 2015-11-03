<?php
namespace Chaplean\Bundle\CmsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Embeddable
 * @ORM\Table(name="cl_page")
 */
class Page
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
     * @ORM\Column(type="string", length=250, nullable=false, name="title")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="subtitle")
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="content")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="meta_description")
     */
    private $metaDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     */
    private $dateAdd;

    /**
     * @var Publication
     *
     * @ORM\Embedded(class="Chaplean\Bundle\CmsBundle\Entity\Publication")
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
     * Get subtitle.
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set subtitle.
     *
     * @param string $subtitle
     *
     * @return self
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

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
     * Get metaDescription.
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaDescription.
     *
     * @param string $metaDescription
     *
     * @return self
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

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
