<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadBlockData.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class LoadBlockData extends AbstractFixture implements DependentFixtureInterface
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

        $datas = [
            '1'  => [$lastMonth, 'publication-passed-published-highlighted'],
            '2'  => [$lastMonth, 'publication-passed-published-not-highlighted'],
            '3'  => [$lastMonth, 'publication-passed-unpublished-highlighted'],
            '4'  => [$lastMonth, 'publication-passed-unpublished-not-highlighted'],
            '5'  => [$yesterday, 'publication-current-published-highlighted'],
            '6'  => [$yesterday, 'publication-current-published-not-highlighted'],
            '7'  => [$yesterday, 'publication-current-unpublished-highlighted'],
            '8'  => [$yesterday, 'publication-current-unpublished-not-highlighted'],
            '9'  => [$yesterday, 'publication-incoming-published-highlighted'],
            '10' => [$yesterday, 'publication-incoming-published-not-highlighted'],
            '11' => [$yesterday, 'publication-incoming-unpublished-highlighted'],
            '12' => [$yesterday, 'publication-incoming-unpublished-not-highlighted'],
        ];

        foreach ($datas as $key => $data) {
            /** @var Publication $publication */
            $publication = $this->getReference($data[1]);
            
            $block = new Block();
            $block->setName('Block-' . $key);
            $block->setContent('<p>Big Content ' . $key . '</p>');
            $block->setDateAdd($data[0]);
            $block->setPublication($publication);

            $manager->persist($block);
            $this->setReference('block-' . $key, $block);
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
        return [
            'Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData\LoadPublicationData'
        ];
    }
}
