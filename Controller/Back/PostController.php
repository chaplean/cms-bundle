<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Back;

use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
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
     * New action
     *
     * @Route("/administration/post", name="cms_post_new")
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function newAction()
    {
        return $this->editAction(null);
    }

    /**
     * Edit action
     *
     * @Route("/administration/post/{postId}", name="cms_post_edit", requirements={"postId" = "\d+"})
     *
     * @param integer $postId Page Id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($postId = null)
    {
        $form = $this->createForm(PostType::class);

        return $this->render(
            'ChapleanCmsBundle:Back/Post:edit.html.twig',
            [
                'postId' => $postId,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Return posts list
     *
     * @Route("/administration/posts", name="cms_post_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Post:list.html.twig',
            [
                'path' => [
                    $translator->trans('menu.posts')
                ]
            ]
        );
    }
}
