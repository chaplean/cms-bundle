<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;

/**
 * Class LoadPageRouteData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class LoadPageRouteData extends AbstractFixture implements OrderedFixtureInterface
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

        /* Passed page */
        $page = new Page();
        $page->setTitle('Page-1');
        $page->setContent('Page-1-content');
        $page->setMetaDescription('Page-1-meta');
        $page->setPublication($this->getReference('publication-passed-published-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-1');
        $pageRoute->setMenuName('Page-1');
        $pageRoute->setRollover('Page-1-rollover');
        $pageRoute->setDateAdd($lastMonth);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-1', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-2');
        $page->setContent('Page-2-content');
        $page->setMetaDescription('Page-2-meta');
        $page->setPublication($this->getReference('publication-passed-published-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-2');
        $pageRoute->setMenuName('Page-2');
        $pageRoute->setRollover('Page-2-rollover');
        $pageRoute->setDateAdd($lastMonth);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-2', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-3');
        $page->setContent('Page-3-content');
        $page->setMetaDescription('Page-3-meta');
        $page->setPublication($this->getReference('publication-passed-unpublished-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-3');
        $pageRoute->setMenuName('Page-3');
        $pageRoute->setRollover('Page-3-rollover');
        $pageRoute->setDateAdd($lastMonth);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-3', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-4');
        $page->setContent('Page-4-content');
        $page->setMetaDescription('Page-4-meta');
        $page->setPublication($this->getReference('publication-passed-unpublished-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-4');
        $pageRoute->setMenuName('Page-4');
        $pageRoute->setRollover('Page-4-rollover');
        $pageRoute->setDateAdd($lastMonth);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-4', $pageRoute);
        /* Passed page - end */


        /* Current page */
        $page = new Page();
        $page->setTitle('Page-5');
        $page->setContent('Page-5-content');
        $page->setMetaDescription('Page-5-meta');
        $page->setPublication($this->getReference('publication-current-published-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-5');
        $pageRoute->setMenuName('Page-5');
        $pageRoute->setRollover('Page-5-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-5', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-6');
        $page->setContent('Page-6-content');
        $page->setMetaDescription('Page-6-meta');
        $page->setPublication($this->getReference('publication-current-published-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-6');
        $pageRoute->setMenuName('Page-6');
        $pageRoute->setRollover('Page-6-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-6', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-7');
        $page->setContent('Page-7-content');
        $page->setMetaDescription('Page-7-meta');
        $page->setPublication($this->getReference('publication-current-unpublished-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-7');
        $pageRoute->setMenuName('Page-7');
        $pageRoute->setRollover('Page-7-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-7', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-8');
        $page->setContent('Page-8-content');
        $page->setMetaDescription('Page-8-meta');
        $page->setPublication($this->getReference('publication-current-unpublished-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-8');
        $pageRoute->setMenuName('Page-8');
        $pageRoute->setRollover('Page-8-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-8', $pageRoute);
        /* Current page - end */

        /* Incoming page */
        $page = new Page();
        $page->setTitle('Page-9');
        $page->setContent('Page-9-content');
        $page->setMetaDescription('Page-9-meta');
        $page->setPublication($this->getReference('publication-incoming-published-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-9');
        $pageRoute->setMenuName('Page-9');
        $pageRoute->setRollover('Page-9-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-9', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-10');
        $page->setContent('Page-10-content');
        $page->setMetaDescription('Page-10-meta');
        $page->setPublication($this->getReference('publication-incoming-published-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-10');
        $pageRoute->setMenuName('Page-10');
        $pageRoute->setRollover('Page-10-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-10', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-11');
        $page->setContent('Page-11-content');
        $page->setMetaDescription('Page-11-meta');
        $page->setPublication($this->getReference('publication-incoming-unpublished-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-11');
        $pageRoute->setMenuName('Page-11');
        $pageRoute->setRollover('Page-11-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-11', $pageRoute);


        $page = new Page();
        $page->setTitle('Page-12');
        $page->setContent('Page-12-content');
        $page->setMetaDescription('Page-12-meta');
        $page->setPublication($this->getReference('publication-incoming-unpublished-not-highlighted'));

        $pageRoute = new PageRoute();
        $pageRoute->setPath('page-12');
        $pageRoute->setMenuName('Page-12');
        $pageRoute->setRollover('Page-12-rollover');
        $pageRoute->setDateAdd($yesterday);
        $pageRoute->setPage($page);

        $manager->persist($pageRoute);
        $this->setReference('page-route-12', $pageRoute);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 20;
    }
}
