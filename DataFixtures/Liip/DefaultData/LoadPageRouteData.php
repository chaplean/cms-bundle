<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;

/**
 * Class LoadPageRouteData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Benoit - Chaplean <benoit@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class LoadPageRouteData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $now = new \DateTime('now');

        $yesterday = clone $now;
        $yesterday->modify('-1 day');
        $tomorrow = clone $now;
        $tomorrow->modify('+1 day');

        $lastMonth = clone $now;
        $lastMonth->modify('-1 month');
        $nextMonth = clone $now;
        $nextMonth->modify('+1 month');

        $datas = array(
            '1'  => array($lastMonth, 'publication-passed-published-highlighted'),
            '2'  => array($lastMonth, 'publication-passed-published-not-highlighted'),
            '3'  => array($lastMonth, 'publication-passed-unpublished-highlighted'),
            '4'  => array($lastMonth, 'publication-passed-unpublished-not-highlighted'),
            '5'  => array($yesterday, 'publication-current-published-highlighted'),
            '6'  => array($yesterday, 'publication-current-published-not-highlighted'),
            '7'  => array($yesterday, 'publication-current-unpublished-highlighted'),
            '8'  => array($yesterday, 'publication-current-unpublished-not-highlighted'),
            '9'  => array($yesterday, 'publication-incoming-published-highlighted'),
            '10' => array($yesterday, 'publication-incoming-published-not-highlighted'),
            '11' => array($yesterday, 'publication-incoming-unpublished-highlighted'),
            '12' => array($yesterday, 'publication-incoming-unpublished-not-highlighted'),
        );

        foreach ($datas as $key => $data) {
            $page = new Page();
            $page->setTitle('Page-' . $key);
            $page->setContent('Page-' . $key . '-content');
            $page->setMetaDescription('Page-' . $key . '-meta');

            /** @var Publication $publication */
            $publication = $this->getReference($data[1]);

            $pageRoute = new PageRoute();
            $pageRoute->setPath('page-' . $key);
            $pageRoute->setMenuName('Page-' . $key);
            $pageRoute->setRollover('Page-' . $key . '-rollover');
            $pageRoute->setDateAdd($data[0]);
            $pageRoute->setPublication($publication);
            $pageRoute->setPage($page);

            $manager->persist($pageRoute);
            $this->setReference('page-route-' . $key, $pageRoute);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData\LoadPublicationData'
        );
    }
}
