<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Back;

use Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PageController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PageController extends Controller
{
    /**
     * New action
     *
     * @Route("/administration/page", name="cms_page_new")
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
     * @Route("/administration/page/{pageId}", name="cms_page_edit", requirements={"pageId" = "\d+"})
     *
     * @param integer $pageId Page Id
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

        if ($pageId !== null && $pageRoute === null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(PageRouteType::class);
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Page:edit.html.twig',
            [
                'pageId' => ($pageRoute !== null) ? $pageRoute->getId() : null,
                'form' => $form->createView(),
                'path' => [
                    $translator->trans('menu.page')
                ]
            ]
        );
    }

    /**
     * Return pages list
     *
     * @Route("/administration/pages", name="cms_page_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $translator = $this->get('translator');

        return $this->render(
            'ChapleanCmsBundle:Back/Page:list.html.twig',
            [
                'path' => [
                    $translator->trans('menu.pages')
                ]
            ]
        );
    }
}
