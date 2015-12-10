<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PageController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PageController extends Controller
{
    /**
     * Edit action
     *
     * @param Integer $pageId Page Id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($pageId = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $pageRoute */
        $pageRoute = ($pageId !== null) ? $pageRouteRepository->find($pageId) : null;

        if ($pageId !== null && $pageRoute == null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(new PageRouteType());
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Page:edit.html.twig',
            array(
                'pageId' => ($pageRoute !== null) ? $pageRoute->getId() : null,
                'form' => $form->createView(),
                'path' => array(
                    $translator->trans('menu.page')
                )
            )
        );
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $template = $this->getParameter('chaplean_cms.template.page_index');
        return $this->render($template);
    }

    /**
     * Return pages list
     *
     * @return Response
     */
    public function listAction()
    {
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Page:list.html.twig',
            array(
                'path' => array(
                    $translator->trans('menu.pages')
                )
            )
        );
    }

    /**
     * Return the page attached to the given path
     *
     * @param string $pagePath Page path
     *
     * @return Response
     */
    public function viewAction($pagePath)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $pageRoute */
        $pageRoute = $pageRouteRepository->findOneBy(array('path' => $pagePath));

        if ($pageRoute === null) {
            throw $this->createNotFoundException(
                $this->get('translator')
                    ->trans('error.not_found')
            );
        }

        $template = $this->getParameter('chaplean_cms.template.page_view');
        return $this->render(
            $template,
            array(
                'pageRoute' => $pageRoute
            )
        );
    }
}
