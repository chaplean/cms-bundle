<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Repository;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Chaplean\Bundle\UnitBundle\Test\FunctionalTestCase;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * BlockRepositoryTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class BlockRepositoryTest extends FunctionalTestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetAll()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        $this->assertCount(12, $blockRepository->getAll());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetOnly5()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        $this->assertCount(5, $blockRepository->getAll(5));
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetAllOrderByDescId()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        /** @var Block[] $blocks */
        $blocks = $blockRepository->getAll();

        $this->assertEquals(1, $blocks[0]->getId());

        $blocks = $blockRepository->getAll(null, 'id', 'desc');

        $this->assertEquals(12, $blocks[0]->getId());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetAllOrderByAscName()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        /** @var Block[] $blocks */
        $blocks = $blockRepository->getAll();

        $this->assertEquals('Block-1', $blocks[0]->getName());

        $blocks = $blockRepository->getAll(null, 'name', 'asc');

        $this->assertEquals('Block-1', $blocks[0]->getName());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetAllOrderByAscNameLimit5()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        $blocks = new ArrayCollection($blockRepository->getAll(5, 'name', 'asc'));

        $this->assertEquals('Block-1', $blocks->first()->getName());
        $this->assertEquals('Block-2', $blocks->last()->getName());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Repository\CmsRepository::getAll()
     *
     * @return void
     */
    public function testGetAllOrderByDescDatePublicationEnd()
    {
        $blockRepository = $this->em->getRepository('ChapleanCmsBundle:Block');

        $blocks = new ArrayCollection($blockRepository->getAll(null, 'datePublicationEnd', 'desc'));

        $this->assertEquals(12, $blocks->first()->getId());
    }
}
