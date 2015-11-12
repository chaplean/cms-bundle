<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Chaplean\Bundle\CmsBundle\Entity\Publication;

/**
 * Class LoadPublicationData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class LoadPublicationData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
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


        /* Passed publication */
        $publication = new Publication();
        $publication->setDatePublicationBegin($lastMonth);
        $publication->setDatePublicationEnd($yesterday);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($lastMonth);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-passed-published-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($lastMonth);
        $publication->setDatePublicationEnd($yesterday);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($lastMonth);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-passed-published-not-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($lastMonth);
        $publication->setDatePublicationEnd($yesterday);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($lastMonth);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-passed-unpublished-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($lastMonth);
        $publication->setDatePublicationEnd($yesterday);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($lastMonth);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-passed-unpublished-not-highlighted', $publication);
        /* Passed publication - end */

        /* Current publication */
        $publication = new Publication();
        $publication->setDatePublicationBegin($yesterday);
        $publication->setDatePublicationEnd($tomorrow);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-current-published-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($yesterday);
        $publication->setDatePublicationEnd($tomorrow);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-current-published-not-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($yesterday);
        $publication->setDatePublicationEnd($tomorrow);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-current-unpublished-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($yesterday);
        $publication->setDatePublicationEnd($tomorrow);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-current-unpublished-not-highlighted', $publication);
        /* Current publication - end */

        /* Incoming publication */
        $publication = new Publication();
        $publication->setDatePublicationBegin($tomorrow);
        $publication->setDatePublicationEnd($nextMonth);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-incoming-published-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($tomorrow);
        $publication->setDatePublicationEnd($nextMonth);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-published'));

        $manager->persist($publication);
        $this->setReference('publication-incoming-published-not-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($tomorrow);
        $publication->setDatePublicationEnd($nextMonth);
        $publication->setIsHighlighted(true);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-incoming-unpublished-highlighted', $publication);

        $publication = new Publication();
        $publication->setDatePublicationBegin($tomorrow);
        $publication->setDatePublicationEnd($nextMonth);
        $publication->setIsHighlighted(false);
        $publication->setDateAdd($yesterday);
        $publication->setStatus($this->getReference('publication-status-unpublished'));

        $manager->persist($publication);
        $this->setReference('publication-incoming-unpublished-not-highlighted', $publication);
        /* Incoming publication - end */

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}
