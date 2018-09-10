<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Front;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/pages", name="cms_page_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $template = $this->getParameter('chaplean_cms.template.page_index');
        return $this->render($template);
    }

    /**
     * Return the page attached to the given path
     *
     * @Route("/page/{pagePath}", name="cms_page_view")
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
        $pageRoute = $pageRouteRepository->findOneBy(['path' => $pagePath]);

        if ($pageRoute === null) {
            throw $this->createNotFoundException(
                $this->get('translator')
                    ->trans('error.not_found')
            );
        }

        $template = $this->getParameter('chaplean_cms.template.page_view');
        return $this->render(
            $template,
            [
                'pageRoute' => $pageRoute
            ]
        );
    }
}
