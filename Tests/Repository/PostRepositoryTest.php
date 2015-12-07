<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Repository;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Repository\PostRepository;
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
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->postRepository = $this->em->getRepository('ChapleanCmsBundle:Post');
    }

    /**
     * @return void
     */
    public function testGetAll()
    {
        $this->assertCount(15, $this->postRepository->getAll());
    }

    /**
     * @return void
     */
    public function testGetOnly5()
    {
        $this->assertCount(5, $this->postRepository->getAll(5));
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescId()
    {
        /** @var Post[] $posts */
        $posts = $this->postRepository->getAll();

        $this->assertEquals(12, $posts[0]->getId());

        $posts = $this->postRepository->getAll(null, 'id', 'desc');

        $this->assertEquals(15, $posts[0]->getId());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitle()
    {
        /** @var Post[] $posts */
        $posts = $this->postRepository->getAll();

        $this->assertEquals('Page-video-1', $posts[0]->getPage()->getTitle());

        $posts = $this->postRepository->getAll(null, 'title', 'asc');

        $this->assertEquals('Page-news-13', $posts[0]->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByAscTitleLimit5()
    {
        $posts = new ArrayCollection($this->postRepository->getAll(5, 'title', 'asc'));

        // Page-1, Page-10, Page-11, Page-12, Page-2
        $this->assertEquals('Page-news-13', $posts->first()->getPage()->getTitle());
        $this->assertEquals('Page-testimonial-11', $posts->last()->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testGetAllOrderByDescDatePublicationEnd()
    {
        $posts = new ArrayCollection($this->postRepository->getAll(null, 'datePublicationEnd', 'desc'));

        $this->assertEquals(4, $posts->first()->getId());
    }

    /**
     * @return void
     */
    public function testGetByCategoryVideo()
    {
        $posts = $this->postRepository->getByCategory('video');

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
        $posts = $this->postRepository->getByCategory('testimonial');

        $this->assertCount(4, $posts);
        $this->assertInstanceOf(PostTestimonial::class, $posts[0]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[1]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[2]);
        $this->assertInstanceOf(PostTestimonial::class, $posts[3]);
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

        $this->postRepository->castPostTo($post, 'video');

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

        $this->postRepository->castPostTo($post, 'testimonial');

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

        $this->postRepository->castPostTo($post, 'zoom');

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

        $this->postRepository->castPostTo($post, 'video');

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

        $this->postRepository->castPostTo($post, 'news');

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

        $this->postRepository->castPostTo($post, 'video');

        $posts = $this->em->getRepository('ChapleanCmsBundle:PostVideo')->findAll();
        $this->assertCount(4, $posts);
    }

    /**
     * @return void
     */
    public function testGetAllActive()
    {
        /** @var Post[] $postsActive */
        $postsActive = $this->postRepository->getAllActive();

        $this->assertCount(2, $postsActive);
        $this->assertEquals('Page-zoom-5', $postsActive[0]->getPage()->getTitle());
        $this->assertEquals('Page-zoom-6', $postsActive[1]->getPage()->getTitle());
    }

    /**
     * @return void
     */
    public function testFindActiveWithPost()
    {
        $id = self::$fixtures->getReference('post-zoom-5')->getId();

        $post = $this->postRepository->findActive($id);

        $this->assertNotNull($post);
        $this->assertInstanceOf(Post::class, $post);
    }

    /**
     * @return void
     */
    public function testFindActiveWithInactivePost()
    {
        $id = self::$fixtures->getReference('post-video-1')->getId();

        $post = $this->postRepository->findActive($id);

        $this->assertNull($post);
    }
}
