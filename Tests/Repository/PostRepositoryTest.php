<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Repository;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PostRepositoryTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostRepositoryTest extends LogicalTest
{
    /**
     * @return void
     */
    public function testGetAll()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $this->assertCount(15, $postRepository->getAll());
    }

    /**
     * @return void
     */
    public function testGetOnly5()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $this->assertCount(5, $postRepository->getAll(5));
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescId()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        /** @var Post[] $posts */
        $posts = $postRepository->getAll();

        $this->assertEquals(12, $posts[0]->getId());

        $posts = $postRepository->getAll(null, 'id', 'desc');

        $this->assertEquals(15, $posts[0]->getId());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitle()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        /** @var Post[] $posts */
        $posts = $postRepository->getAll();

        $this->assertEquals('Page-video-1', $posts[0]->getPage()->getTitle());

        $posts = $postRepository->getAll(null, 'title', 'asc');

        $this->assertEquals('Page-news-13', $posts[0]->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitleLimit5()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $posts = new ArrayCollection($postRepository->getAll(5, 'title', 'asc'));

        // Page-1, Page-10, Page-11, Page-12, Page-2
        $this->assertEquals('Page-news-13', $posts->first()->getPage()->getTitle());
        $this->assertEquals('Page-testimonial-11', $posts->last()->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescDatePublicationEnd()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $posts = new ArrayCollection($postRepository->getAll(null, 'datePublicationEnd', 'desc'));

        $this->assertEquals(4, $posts->first()->getId());
    }

    /**
     * @return void
     */
    public function testGetByCategoryVideo()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $posts = $postRepository->getByCategory('video');

        $this->assertCount(4, $posts);
        $this->assertInstanceOf(PostVideo::class, $posts[0]);
        $this->assertInstanceOf(PostVideo::class, $posts[1]);
        $this->assertInstanceOf(PostVideo::class, $posts[2]);
        $this->assertInstanceOf(PostVideo::class, $posts[3]);
    }

    /**
     * @return void
     */
    public function testGetByCategoryTestimonial()
    {
        $postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');

        $posts = $postRepository->getByCategory('testimonial');

        $this->assertCount(4, $posts);
        $this->assertInstanceOf(PostTestimonial::class, $posts[0]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[1]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[2]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[3]);
    }
}
