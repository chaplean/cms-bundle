<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Repository;

use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Chaplean\Bundle\UnitBundle\Test\LogicalTestCase;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PageRouteRepositoryTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PageRouteRepositoryTest extends LogicalTestCase
{
    /**
     * @return void
     */
    public function testGetAll()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        $this->assertCount(12, $pageRouteRepository->getAll());
    }

    /**
     * @return void
     */
    public function testGetOnly5()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        $this->assertCount(5, $pageRouteRepository->getAll(5));
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescId()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute[] $pageRoutes */
        $pageRoutes = $pageRouteRepository->getAll();

        $this->assertEquals(1, $pageRoutes[0]->getId());

        $pageRoutes = $pageRouteRepository->getAll(null, 'id', 'desc');

        $this->assertEquals(12, $pageRoutes[0]->getId());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitle()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute[] $pageRoutes */
        $pageRoutes = $pageRouteRepository->getAll();

        $this->assertEquals('Page-1', $pageRoutes[0]->getPage()->getTitle());

        $pageRoutes = $pageRouteRepository->getAll(null, 'title', 'asc');

        $this->assertEquals('Page-1', $pageRoutes[0]->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitleLimit5()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        $pageRoutes = new ArrayCollection($pageRouteRepository->getAll(5, 'title', 'asc'));

        // Page-1, Page-10, Page-11, Page-12, Page-2
        $this->assertEquals('Page-1', $pageRoutes->first()->getPage()->getTitle());
        $this->assertEquals('Page-2', $pageRoutes->last()->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescDatePublicationEnd()
    {
        $pageRouteRepository = $this->em->getRepository('ChapleanCmsBundle:PageRoute');

        $pageRoutes = new ArrayCollection($pageRouteRepository->getAll(null, 'datePublicationEnd', 'desc'));

        $this->assertEquals(9, $pageRoutes->first()->getId());
    }
}
