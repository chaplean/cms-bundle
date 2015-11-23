<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Entity;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;

/**
 * PostTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostTest extends LogicalTest
{
    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        parent::$iWantDefaultData = false;
        parent::setUpBeforeClass();
    }

    /**
     * @return void
     */
    public function testGetInstanceOf()
    {
        $postVideo = new PostVideo();

        $this->assertEquals('video', $postVideo->getInstanceOf());

        $postTestimonial = new PostTestimonial();

        $this->assertEquals('testimonial', $postTestimonial->getInstanceOf());

        $postZoom = new PostZoom();

        $this->assertEquals('zoom', $postZoom->getInstanceOf());

        $post = new Post();

        $this->assertEquals('news', $post->getInstanceOf());
    }

    /**
     * @return void
     */
    public function testGetClassByInstance()
    {
        $this->assertEquals(Post::class, Post::getClassByInstance('news'));
        $this->assertEquals(PostTestimonial::class, Post::getClassByInstance('testimonial'));
        $this->assertEquals(PostVideo::class, Post::getClassByInstance('video'));
        $this->assertEquals(PostZoom::class, Post::getClassByInstance('zoom'));
    }
}
