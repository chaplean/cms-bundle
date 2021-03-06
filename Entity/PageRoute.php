<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="Chaplean\Bundle\CmsBundle\Repository\PageRouteRepository")
 * @ORM\Table(
 *     name="cl_page_route",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="page_route_path_UNIQUE", columns={"path"})}
 * )
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
     * @JMS\Groups({"page_route_id", "page_route_all"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=250, nullable=false, name="path")
     *
     * @JMS\Groups({"page_route_path", "page_route_all"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="menu_name")
     *
     * @JMS\Groups({"page_route_menu_name", "page_route_all"})
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=true, name="rollover")
     *
     * @JMS\Groups({"page_route_rollover", "page_route_all"})
     */
    private $rollover;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     *
     * @JMS\Groups({"page_route_date_add", "page_route_all"})
     */
    private $dateAdd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="date_update")
     *
     * @JMS\Groups({"page_route_date_update", "page_route_all"})
     */
    private $dateUpdate;

    /**
     * @var Publication
     *
     * @ORM\OneToOne(targetEntity="Chaplean\Bundle\CmsBundle\Entity\Publication")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id", nullable=false, unique=true)
     *
     * @JMS\Groups({"page_route_publication", "page_route_all"})
     */
    private $publication;

    /**
     * @var Page
     *
     * @ORM\Embedded(class="Chaplean\Bundle\CmsBundle\Entity\Page", columnPrefix=false)
     *
     * @JMS\Groups({"page_route_page", "page_route_all"})
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
}
