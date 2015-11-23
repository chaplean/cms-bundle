<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Utility\Entity;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Utility\Entity\PostCast;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;

/**
 * PostCastTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostCastTest extends LogicalTest
{
    /**
     * @var PostCast
     */
    private $postCastUtility;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->postCastUtility = $this->getContainer()->get('chaplean_cms.post_cast_utility');
    }

    /**
     * @return void
     */
    public function testCastPostToVideo()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-news-13');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'video');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(5, $posts);
    }

    /**
     * @return void
     */
    public function testCastPostToTestimonial()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-news-13');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostTestimonial')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'testimonial');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostTestimonial')->findAll();
        $this->assertCount(5, $posts);
    }

    /**
     * @return void
     */
    public function testCastPostToZoom()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-news-13');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostZoom')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'zoom');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostZoom')->findAll();
        $this->assertCount(5, $posts);
    }

    /**
     * @return void
     */
    public function testCastPostZoomToVideo()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-zoom-5');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'video');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(5, $posts);
    }

    /**
     * @return void
     */
    public function testCastPostVideoToPost()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-video-1');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'news');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(3, $posts);
    }

    /**
     * @return void
     */
    public function testCastPostVideoToPostVideo()
    {
        /** @var Post $post */
        $post = $this->getRealEntity('post-video-1');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);

        $this->postCastUtility->castPostTo($post, 'video');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);
    }
}
