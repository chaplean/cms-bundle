<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Form\Type\PageType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    /**
     * Return the page attached to the given id
     *
     * @param integer $pageId Page Id
     *
     * @return Response
     */
    public function identifierAction($pageId)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $page */
        $page = $pageRouteRepository->find($pageId);

        if ($page === null) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('error.not_found')
            );
        }

        return $this->redirect(
            $this->generateUrl(
                'chaplean_cms_content',
                array(
                    'pagePath' => $page->getPath()
                )
            ),
            301
        );
    }

    /**
     * Return the page attached to the given path
     *
     * @param string $pagePath Page path
     *
     * @return Response
     */
    public function indexAction($pagePath)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $page */
        $page = $pageRouteRepository->findOneBy(array('path' => $pagePath));

        if ($page === null) {
            throw $this->createNotFoundException(
                $this->get('translator')
                    ->trans('error.not_found')
            );
        }

        // redirect to the correct page
        return $this->render(
            'ChapleanCmsBundle:Content:index.html.twig',
            array(
                'page' => $page
            )
        );
    }

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
        /** @var EntityRepository $pageRepo */
        $pageRepo = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $page */
        $page = ($pageId !== null) ? $pageRepo->find($pageId) : null;

        if ($pageId !== null && $page == null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(new PageType());
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Page:edit.html.twig',
            array(
                'pageId' => ($page !== null) ? $page->getId() : null,
                'form' => $form->createView(),
                'path' => $translator->trans('menu.page')
            )
        );
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
            'ChapleanCmsBundle:Page:list.html.twig',
            array(
                'path' => $translator->trans('menu.pages')
            )
        );
    }
}
