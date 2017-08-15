<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * PostUtilityTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PostUtilityTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\PostUtility::getClassByInstance()
     *
     * @return void
     */
    public function testGetClassByInstance()
    {
        $this->assertEquals(Post::class, PostUtility::getClassByInstance('news'));
        $this->assertEquals(PostTestimonial::class, PostUtility::getClassByInstance('testimonial'));
        $this->assertEquals(PostVideo::class, PostUtility::getClassByInstance('video'));
        $this->assertEquals(PostZoom::class, PostUtility::getClassByInstance('zoom'));
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\PostUtility::getClassByInstance()
     *
     * @return void
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Not defined foo type for post.
     */
    public function testGetClassByInstanceWithNotExistInstance()
    {
        $this->assertEquals(Post::class, PostUtility::getClassByInstance('foo'));
    }
}
