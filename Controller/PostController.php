<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
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
        $form = $this->createForm(new PostType());

        return $this->render(
            'ChapleanCmsBundle:Post:edit.html.twig',
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
            'ChapleanCmsBundle:Post:list.html.twig',
            array(
                'path' => array(
                    $translator->trans('menu.posts')
                )
            )
        );
    }
}
