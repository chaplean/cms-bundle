<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Entity;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use PHPUnit\Framework\TestCase;

/**
 * PostTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PostTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Post::getInstanceOf()
     *
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
}
