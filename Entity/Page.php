<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Embeddable
 * @ORM\Table(name="cl_page")
 */
class Page
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="title")
     *
     * @JMS\Groups({"page_title", "page_all"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="subtitle")
     *
     * @JMS\Groups({"page_subtitle", "page_all"})
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="content")
     *
     * @JMS\Groups({"page_content", "page_all"})
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="meta_description")
     *
     * @JMS\Groups({"page_meta_description", "page_all"})
     */
    private $metaDescription;

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
}
