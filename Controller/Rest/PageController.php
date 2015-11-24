<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PageController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller\Rest
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Page")
 */
class PageController extends ChapleanRestController
{
    /**
     * Delete page
     *
     * @param PageRoute $pageRoute
     *
     * @return Response
     */
    public function deleteAction(PageRoute $pageRoute)
    {
        return $this->delete($pageRoute);
    }

    /**
     * Get one page
     *
     * @param PageRoute $pageRoute
     *
     * @return Response
     */
    public function getAction(PageRoute $pageRoute)
    {
        return $this->handleResponse($pageRoute, array(
            'page_route_all', 'publication_id', 'publication_date_publication_begin', 'publication_date_publication_end',
            'publication_date_add', 'publication_status', 'publication_status_id', 'publication_status_keyname',
            'publication_status_position', 'page_all',
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        return $this->getAll($request, 'ChapleanCmsBundle:PageRoute', array(
            'page_route_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname', 'publication_status_position'
        ));
    }

    /**
     * Save page
     *
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
        $formPage = $this->createForm(new PageRouteType());

        // bind data in form
        $formPage->submit($request->request->all());

        if ($formPage->isValid()) {
            $pageRoute = null;

            try {
                $pageRoute = $formPage->getData();
                $pageRoute->setDateAdd(new \DateTime());

                /** @var Publication $publication */
                $publication = $pageRoute->getPublication();
                $publication->setIsHighlighted(false);
                $publication->setDateAdd(new \DateTime());
                $em->persist($publication);
                $em->flush();

                $pageRoute->setPublication($publication);
                $em->persist($pageRoute);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Page creation failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($pageRoute, array(
                'page_route_all', 'publication_id', 'publication_date_publication_begin', 'publication_date_publication_end',
                'publication_date_add', 'publication_status', 'publication_status_id', 'publication_status_keyname',
                'publication_status_position', 'page_all',
            ));
        }

        return $this->handleView($this->view($formPage->getErrors(true), 400));
    }

    /**
     * Update page
     *
     * @param Request   $request
     * @param PageRoute $pageRoute
     *
     * @return Response
     */
    public function putAction(Request $request, PageRoute $pageRoute)
    {
        /** @var Logger $logger */
        $logger = $this->get('logger');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (empty($pageRoute)) {
            return $this->handleView($this->view('Page not found', 404));
        }

        // create form and get params
        $formPage = $this->createForm(new PageRouteType(), $pageRoute);

        // bind data in form
        $formPage->submit($request->request->all());

        if ($formPage->isValid()) {
            try {
                $pageRoute = $formPage->getData();
                $pageRoute->setDateUpdate(new \DateTime());

                $em->persist($pageRoute);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Page update failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($pageRoute, array(
                'page_route_all', 'publication_id', 'publication_date_publication_begin', 'publication_date_publication_end',
                'publication_date_add', 'publication_status', 'publication_status_id', 'publication_status_keyname',
                'publication_status_position', 'page_all',
            ));
        }

        return $this->handleView($this->view($formPage->getErrors(true), 400));
    }
}
