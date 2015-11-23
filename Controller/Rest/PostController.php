<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RestPostController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Post")
 */
class PostController extends ChapleanRestController
{
    /**
     * Delete post
     *
     * @param Post $post
     *
     * @return Response
     */
    public function deleteAction(Post $post)
    {
        return $this->delete($post);
    }

    /**
     * @param Post $post
     *
     * @return Response
     */
    public function getAction(Post $post)
    {
        return $this->handleResponse($post, array(
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname'
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        return $this->getAll($request, 'ChapleanCmsBundle:Post', array(
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname'
        ));
    }

    /**
     * @param Request $request
     * @param string  $category
     *
     * @return Response
     */
    public function getCategoryAction(Request $request, $category)
    {
        $limit = $request->query->get('limit', null);
        $sort  = $request->query->get('sort', null);
        $order = $request->query->get('order', null);

        $posts = $this->getDoctrine()->getRepository('ChapleanCmsBundle:Post')->getByCategory($category, $limit, $sort, $order);

        return $this->handleResponse($posts, array(
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname'
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        /** @var Logger $logger */
        $logger = $this->get('logger');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        // create form and get params
        $formPost = $this->createForm(new PostType());

        // bind data in form
        $formPost->submit($request->request->all());

        if ($formPost->isValid()) {
            $post = null;

            try {
                $em->beginTransaction();

                $post = $formPost->getData();
                $post->setDateAdd(new \DateTime());

                /** @var Publication $publication */
                $publication = $post->getPublication();
                $publication->setDateAdd(new \DateTime());
                $em->persist($publication);
                $em->flush();

                $post->setPublication($publication);
                $em->persist($post);
                $em->flush();

                $em->commit();
            } catch (\Exception $e) {
                $em->rollback();

                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Post creation failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($post, array(
                'post_all', 'publication_all', 'page_all',
                'publication_status_id', 'publication_status_keyname'
            ));
        }

        return $this->handleView($this->view($formPost->getErrors(true), 400));
    }

    /**
     * @param Request $request
     * @param Post    $post
     *
     * @return Response
     */
    public function putAction(Request $request, Post $post)
    {
        /** @var Logger $logger */
        $logger = $this->get('logger');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $postCastUtility = $this->get('chaplean_cms.post_cast_utility');

        if (empty($post)) {
            return $this->handleView($this->view('Post not found', 404));
        }

        $parameters = $request->request->all();
        $category = $parameters['category'];

        unset($parameters['category']);

        // create form and get params
        $formPost = $this->createForm(new PostType(), $post);

        // bind data in form
        $formPost->submit($request->request->all());

        if ($formPost->isValid()) {
            try {
                /** @var Post $post */
                $post = $formPost->getData();

                $postCastUtility->castPostTo($post, $category);
                $post->setDateUpdate(new \DateTime());

                $em->persist($post);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Post update failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($post, array(
                'post_all', 'publication_all', 'page_all',
                'publication_status_id', 'publication_status_keyname'
            ));
        }

        return $this->handleView($this->view($formPost->getErrors(true), 400));
    }
}
