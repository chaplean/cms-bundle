<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use Chaplean\Bundle\CmsBundle\Entity\Post;
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
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
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

        $datas = [
            '1'  => ['video', new PostVideo(), $lastMonth, 'publication-passed-published-highlighted'],
            '2'  => ['video', new PostVideo(), $lastMonth, 'publication-passed-published-not-highlighted'],
            '3'  => ['video', new PostVideo(), $lastMonth, 'publication-passed-unpublished-highlighted'],
            '4'  => ['video', new PostVideo(), $lastMonth, 'publication-passed-unpublished-not-highlighted'],
            '5'  => ['zoom', new PostZoom(), $yesterday, 'publication-current-published-highlighted'],
            '6'  => ['zoom', new PostZoom(), $yesterday, 'publication-current-published-not-highlighted'],
            '7'  => ['zoom', new PostZoom(), $yesterday, 'publication-current-unpublished-highlighted'],
            '8'  => ['zoom', new PostZoom(), $yesterday, 'publication-current-unpublished-not-highlighted'],
            '9'  => ['testimonial', new PostTestimonial(), $yesterday, 'publication-incoming-published-highlighted'],
            '10' => ['testimonial', new PostTestimonial(), $yesterday, 'publication-incoming-published-not-highlighted'],
            '11' => ['testimonial', new PostTestimonial(), $yesterday, 'publication-incoming-unpublished-highlighted'],
            '12' => ['testimonial', new PostTestimonial(), $yesterday, 'publication-incoming-unpublished-not-highlighted'],
            '13' => ['news', new Post(), $yesterday, 'publication-incoming-published-not-highlighted-1'],
            '14' => ['news', new Post(), $yesterday, 'publication-incoming-unpublished-highlighted-1'],
            '15' => ['news', new Post(), $yesterday, 'publication-incoming-unpublished-not-highlighted-1'],
        ];

        foreach ($datas as $key => $data) {
            // Page is embeddable, so it should stay here !
            $page = new Page();
            $page->setTitle('Page-' . $data[0] . '-' . $key);
            $page->setContent('Page-' . $data[0] . '-' . $key . '-content');
            $page->setMetaDescription('Page-' . $data[0] . '-' . $key . '-meta');

            /** @var Publication $publication */
            $publication = $this->getReference($data[3]);

            /** @var PostVideo|PostZoom|PostTestimonial $post */
            $post = $data[1];
            $post->setDateAdd($data[2]);
            $post->setPublication($publication);
            $post->setPage($page);

            $this->persist($post, $manager);
            $this->setReference('post-' . $data[0] . '-' . $key, $post);
            $this->setReference('post-' . $key, $post);

            // We flush on each turn because if we dont the order of datas in database is random
            $manager->flush();
        }
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
