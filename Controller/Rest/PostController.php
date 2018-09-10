<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
use Chaplean\Bundle\CmsBundle\Utility\ErrorFormUtility;
use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations;
use Monolog\Logger;
use Symfony\Component\Debug\Exception\UndefinedMethodException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RestPostController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
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
        return $this->handleResponse($post, [
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname'
        ]
        );
    }

    /**
     * @return Response
     */
    public function getAvailableCategoriesAction()
    {
        $categories = $this->getParameter('chaplean_cms.modules.post.category');

        if (is_bool($categories) && $categories) {
            $categories = array_values(PostUtility::getAvailableInstance());
        } else {
            if (!in_array('news', $categories)) {
                $categories[] = 'news';
            }
        }

        return $this->handleResponse($categories);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        return $this->getAll($request, 'ChapleanCmsBundle:Post', [
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname',
            'page_image_source', 'page_strip_content'
        ]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws UndefinedMethodException
     */
    public function getAllActiveAction(Request $request)
    {
        return $this->getAllActive($request, 'ChapleanCmsBundle:Post', [
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname',
            'page_image_source', 'page_strip_content'
        ]
        );
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

        return $this->handleResponse($posts, [
            'post_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname'
        ]
        );
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
        $postRepository = $em->getRepository('ChapleanCmsBundle:Post');

        $parameters = $request->request->all();
        $category = $parameters['category'];

        // create form and get params
        $formPost = $this->createForm(PostType::class);

        // bind data in form
        $formPost->submit($parameters);

        if ($formPost->isValid()) {
            $post = null;

            try {
                $em->beginTransaction();

                $post = $formPost->getData();
                $post->setDateAdd(new \DateTime());

                /** @var Publication $publication */
                $publication = $post->getPublication();
                if (empty($publication->isIsHighlighted())) {
                    $publication->setIsHighlighted(false);
                }

                $publication->setDateAdd(new \DateTime());
                $em->persist($publication);
                $em->flush();

                $post->setPublication($publication);
                $em->persist($post);
                $em->flush();

                $em->commit();
                $postRepository->castPostTo($post, $category);
            } catch (\Exception $e) {
                $em->rollback();

                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Post creation failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($post, [
                'post_all', 'publication_all', 'page_all',
                'publication_status_id', 'publication_status_keyname'
            ]
            );
        }

        return $this->handleView($this->view(ErrorFormUtility::getErrorsForAngular($formPost->getErrors(true), $formPost->getName()), 400));
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
        $postRepository = $em->getRepository('ChapleanCmsBundle:Post');

        if (empty($post)) {
            return $this->handleView($this->view('Post not found', 404));
        }

        $parameters = $request->request->all();
        $category = $parameters['category'];

        unset($parameters['category']);

        // create form and get params
        $formPost = $this->createForm(PostType::class, $post);

        // bind data in form
        $formPost->submit($request->request->all());

        if ($formPost->isValid()) {
            try {
                /** @var Post $post */
                $post = $formPost->getData();

                $postRepository->castPostTo($post, $category);
                $post->setDateUpdate(new \DateTime());

                $em->persist($post);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Post update failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($post, [
                'post_all', 'publication_all', 'page_all',
                'publication_status_id', 'publication_status_keyname'
            ]
            );
        }

        return $this->handleView($this->view(ErrorFormUtility::getErrorsForAngular($formPost->getErrors(true), $formPost->getName()), 400));
    }
}
