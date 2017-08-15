<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\ORM;

use Chaplean\Bundle\CmsBundle\Entity\PublicationStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadPublicationStatusData.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class LoadPublicationStatusData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $status = new PublicationStatus();
        $status->setPosition(1);
        $status->setKeyname('published');
        $manager->persist($status);

        $status = new PublicationStatus();
        $status->setPosition(2);
        $status->setKeyname('unpublished');
        $manager->persist($status);

        $status = new PublicationStatus();
        $status->setPosition(3);
        $status->setKeyname('archived');
        $manager->persist($status);

        $manager->flush();
    }
}
