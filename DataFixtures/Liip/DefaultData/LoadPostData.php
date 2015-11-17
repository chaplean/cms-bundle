<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadPostData.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     X.Y.Z
 */
class LoadPostData extends AbstractFixture implements DependentFixtureInterface
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

        $datas = array(
            '1'  => array(new PostVideo()      , $lastMonth, 'publication-passed-published-highlighted'),
            '2'  => array(new PostVideo()      , $lastMonth, 'publication-passed-published-not-highlighted'),
            '3'  => array(new PostVideo()      , $lastMonth, 'publication-passed-unpublished-highlighted'),
            '4'  => array(new PostVideo()      , $lastMonth, 'publication-passed-unpublished-not-highlighted'),
            '5'  => array(new PostZoom()       , $yesterday, 'publication-current-published-highlighted'),
            '6'  => array(new PostZoom()       , $yesterday, 'publication-current-published-not-highlighted'),
            '7'  => array(new PostZoom()       , $yesterday, 'publication-current-unpublished-highlighted'),
            '8'  => array(new PostZoom()       , $yesterday, 'publication-current-unpublished-not-highlighted'),
            '9'  => array(new PostTestimonial(), $yesterday, 'publication-incoming-published-highlighted'),
            '10' => array(new PostTestimonial(), $yesterday, 'publication-incoming-published-not-highlighted'),
            '11' => array(new PostTestimonial(), $yesterday, 'publication-incoming-unpublished-highlighted'),
            '12' => array(new PostTestimonial(), $yesterday, 'publication-incoming-unpublished-not-highlighted'),
        );

        foreach ($datas as $key => $data) {
            $page = new Page();
            $page->setTitle('Page-' . $key);
            $page->setContent('Page-' . $key . '-content');
            $page->setMetaDescription('Page-' . $key . '-meta');

            /** @var Publication $publication */
            $publication = $this->getReference($data[2]);

            /** @var PostVideo|PostZoom|PostTestimonial $post */
            $post = $data[0];
            $post->setDateAdd($data[1]);
            $post->setPublication($publication);
            $post->setPage($page);

            $manager->persist($post);
            $this->setReference('post-' . $key, $post);
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
