<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Utility;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 * PostUtilityTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostUtilityTest extends LogicalTest
{
    /**
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
     * @return void
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Not defined foo type for post.
     */
    public function testGetClassByInstanceWithNotExistInstance()
    {
        $this->assertEquals(Post::class, PostUtility::getClassByInstance('foo'));
    }
}
