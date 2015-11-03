<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use Chaplean\Bundle\CmsBundle\Entity\PageRoute;
use Chaplean\Bundle\CmsBundle\Form\Type\PageType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use JMS\SecurityExtraBundle\Annotation as JSE;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestPageController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Page")
 */
class RestPageController extends FOSRestController
{
    /**
     * Remove a page
     *
     * @param integer $pageId
     *
     * @return Response
     */
    public function deleteAction($pageId)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $em->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $pageRoute */
        $pageRoute = $pageRouteRepository->find($pageId);

        $success = true;
        $errors = array();
        try {
            $em->remove($pageRoute->getPage());
            $em->remove($pageRoute);
            $em->flush();
        } catch (\Exception $e) {
            $success = false;
            $errors[] = $e->getMessage();
        }

        if ($success) {
            return $this->handleView(new View('success'));
        } else {
            return $this->handleView(new View($errors, 500));
        }
    }

    /**
     * Send page
     *
     * @param integer $pageId Page route Id
     *
     * @return Response
     */
    public function getAction($pageId)
    {
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $this->getDoctrine()->getRepository('');
        $pageRoute = $pageRouteRepository->find($pageId);

        return $this->handleView(new View($pageRoute));
    }

    /**
     * Send pages
     *
     * @return Response
     */
    public function getAllAction()
    {
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $this->getDoctrine()->getRepository('ChapleanCmsBundle:PageRoute');
        $pagesRoute = $pageRouteRepository->findAll();

        return $this->handleView(new View($pagesRoute));
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
        $formPage = $this->createForm(new PageType());
        $params   = $request->request->all();

        // bind data in form
        $formPage->submit($params);

        if ($formPage->isValid()) {
            $pageRoute = null;

            try {
                $page = new Page();
                $page->setTitle($params['title']);
                $page->setContent($params['content']);
                $page->setMetaDescription($params['metaDescription']);

                $pageRoute = new PageRoute();
                $pageRoute->setPath($params['path']);
                $pageRoute->setLabel($params['label']);
                $pageRoute->setRollover(isset($params['rollover']) ? $params['rollover'] : null);
                $pageRoute->setDateAdd(new \DateTime());
                $pageRoute->setPage($page);

                $em->persist($page);
                $em->persist($pageRoute);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView(new View('Page creation failed', 400));
            }

            return $this->handleView(new View($pageRoute));
        }

        return $this->handleView(new View($formPage->getErrors(true), 400));
    }

    /**
     * Update page
     *
     * @param Request $request
     * @param integer $pageId  Page route Id
     *
     * @return Response
     */
    public function putAction(Request $request, $pageId)
    {
        /** @var Logger $logger */
        $logger = $this->get('logger');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $pageRouteRepository */
        $pageRouteRepository = $this->getDoctrine()->getRepository('ChapleanCmsBundle:PageRoute');

        /** @var PageRoute $pageRoute */
        $pageRoute = $pageRouteRepository->find($pageId);

        if ($pageRoute === null) {
            return $this->handleView(new View('Page not found', 400));
        }

        // create form and get params
        $formPage = $this->createForm(new PageType());
        $params   = $request->request->all();

        // bind data in form
        $formPage->submit($params);

        if ($formPage->isValid()) {
            try {
                $page  = $pageRoute->getPage();

                $pageRoute->setPath($params['path']);
                $pageRoute->setLabel($params['label']);
                $pageRoute->setRollover(isset($params['rollover']) ? $params['rollover'] : null);
                $pageRoute->setDateUpdate(new \DateTime());
                $page->setTitle($params['title']);
                $page->setContent($params['content']);
                $page->setMetaDescription($params['metaDescription']);

                $em->persist($pageRoute);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView(new View('Page update failed', 400));
            }

            return $this->handleView(new View($pageRoute));
        }

        return $this->handleView(new View($formPage->getErrors(true), 400));
    }
}
