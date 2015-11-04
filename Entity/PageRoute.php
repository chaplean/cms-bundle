<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_page_route", uniqueConstraints={@ORM\UniqueConstraint(name="path_UNIQUE", columns={"path"})})
 */
class PageRoute
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Groups({"page_route_id"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=250, nullable=false, name="path")
     *
     * @JMS\Groups({"page_route_path"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="menu_name")
     *
     * @JMS\Groups({"page_route_menu_name"})
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="rollover")
     *
     * @JMS\Groups({"page_route_rollover"})
     */
    private $rollover;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     *
     * @JMS\Groups({"page_route_date_add"})
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_update")
     *
     * @JMS\Groups({"page_route_date_update"})
     */
    private $dateUpdate;

    /**
     * @var Page
     *
     * @ORM\Embedded(class="Chaplean\Bundle\CmsBundle\Entity\Page", columnPrefix = false)
     *
     * @JMS\Groups({"page_route_page"})
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
     * Get menuName.
     *
     * @return string
     */
    public function getMenuName()
    {
        return $this->menuName;
    }

    /**
     * Set menuName.
     *
     * @param string $menuName
     *
     * @return self
     */
    public function setMenuName($menuName)
    {
        $this->menuName = $menuName;

        return $this;
    }

    /**
     * Get rollover.
     *
     * @return string
     */
    public function getRollover()
    {
        return $this->rollover;
    }

    /**
     * Set rollover.
     *
     * @param string $rollover
     *
     * @return self
     */
    public function setRollover($rollover)
    {
        $this->rollover = $rollover;

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
