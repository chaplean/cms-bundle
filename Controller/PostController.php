<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostController extends Controller
{
    /**
     * Edit action
     *
     * @param Integer $postId Page Id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($postId = null)
    {
        $form = $this->createForm('chaplean_cms_post_form');

        return $this->render(
            'ChapleanCmsBundle:Back/Post:edit.html.twig',
            array(
                'postId' => $postId,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Return posts list
     *
     * @return Response
     */
    public function listAction()
    {
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Post:list.html.twig',
            array(
                'path' => array(
                    $translator->trans('menu.posts')
                )
            )
        );
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('ChapleanCmsBundle:Front/Post:index.html.twig');
    }

    /**
     * @param integer $postId
     *
     * @return Response
     */
    public function viewAction($postId)
    {
        $em = $this->getDoctrine()->getManager();
        $postRepository = $em->getRepository('ChapleanCmsBundle:Post');

        /** @var Post $post */
        $post = $postRepository->findActive($postId);

        if (empty($post)) {
            throw new NotFoundHttpException;
        }

        return $this->render('ChapleanCmsBundle:Front/Post:view.html.twig', array(
            'post' => $post,
        ));
    }

    /**
     * @param integer $postId
     *
     * @return Response
     */
    public function previewAction($postId)
    {
        $post = $this->getDoctrine()->getManager()->find('ChapleanCmsBundle:Post', $postId);

        if (($this->container->has('security.token_storage') && empty($this->getUser())) || empty($post)) {
            throw new NotFoundHttpException;
        }

        return $this->render('ChapleanCmsBundle:Front/Post:view.html.twig', array(
            'post' => $post,
        ));
    }
}
