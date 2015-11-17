<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use JMS\Serializer\SerializationContext;
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
class PageController extends FOSRestController
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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $success = true;
        $errors = array();
        try {
            $em->remove($pageRoute);
            $em->flush();
        } catch (\Exception $e) {
            $success = false;
            $errors[] = $e->getMessage();
        }

        if ($success) {
            return $this->handleView($this->view());
        } else {
            return $this->handleView($this->view($errors, 500));
        }
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
        $view = $this->view(array('page' => $pageRoute));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array(
            'page_route_all', 'publication_id', 'publication_date_publication_begin', 'publication_date_publication_end',
            'publication_date_add', 'publication_status', 'publication_status_id', 'publication_status_keyname',
            'publication_status_position', 'page_all',
        )));

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        $limit = $request->query->get('limit', null);
        $sort  = $request->query->get('sort', null);
        $order = $request->query->get('order', null);

        $pagesRoute = $this->getDoctrine()->getRepository('ChapleanCmsBundle:PageRoute')->getAll($limit, $sort, $order);

        $view = $this->view(array('pages' => $pagesRoute));
        $view->setSerializationContext(SerializationContext::create()->setGroups(array(
            'page_route_all', 'publication_all', 'page_all',
            'publication_status_id', 'publication_status_keyname', 'publication_status_position'
        )));

        return $this->handleView($view);
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

            return $this->handleView($this->view(array('pageRoute' => $pageRoute)));
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

            return $this->handleView($this->view(array('pageRoute' => $pageRoute)));
        }

        return $this->handleView($this->view($formPage->getErrors(true), 400));
    }
}
