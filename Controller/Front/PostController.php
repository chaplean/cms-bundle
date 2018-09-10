<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Front;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PostController extends Controller
{
    /**
     * @Route("/posts", name="cms_post_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $template = $this->getParameter('chaplean_cms.template.post_index');
        return $this->render($template);
    }

    /**
     * @Route("/post/{postId}", name="cms_post_view")
     *
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

        $template = $this->getParameter('chaplean_cms.template.post_view');
        return $this->render($template, [
            'post' => $post,
        ]
        );
    }

    /**
     * @Route("/preview/post/{postId}", name="cms_post_preview")
     *
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

        $template = $this->getParameter('chaplean_cms.template.post_view');
        return $this->render($template, [
            'post' => $post,
        ]
        );
    }
}
