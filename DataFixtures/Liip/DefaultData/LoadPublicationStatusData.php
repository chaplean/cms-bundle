<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Chaplean\Bundle\CmsBundle\Entity\PublicationStatus;

/**
 * Class LoadPublicationStatusData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Benoit - Chaplean <benoit@chaplean.coop>
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
        $publicationStatus = new PublicationStatus();
        $publicationStatus->setKeyname('published');
        $publicationStatus->setPosition(1);

        $manager->persist($publicationStatus);
        $this->setReference('publication-status-published', $publicationStatus);

        $publicationStatus = new PublicationStatus();
        $publicationStatus->setKeyname('unpublished');
        $publicationStatus->setPosition(2);

        $manager->persist($publicationStatus);
        $this->setReference('publication-status-unpublished', $publicationStatus);

        $publicationStatus = new PublicationStatus();
        $publicationStatus->setKeyname('archived');
        $publicationStatus->setPosition(3);

        $manager->persist($publicationStatus);
        $this->setReference('publication-status-archived', $publicationStatus);

        $manager->flush();
    }
}
