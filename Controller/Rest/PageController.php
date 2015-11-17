<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;
use JMS\Serializer\SerializationContext;
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
class PageController extends FOSRestController
{
    /**
     * Delete page
     *
     * @param Block $block
     *
     * @return Response
     */
    public function deleteAction(Block $block)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $success = true;
        $errors = array();
        try {
            $em->remove($block);
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
     * @param Block $block
     *
     * @return Response
     */
    public function getAction(Block $block)
    {
        $view = $this->view(array('page' => $block));
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

        $blocks = $this->getDoctrine()->getRepository('ChapleanCmsBundle:Block')->getAll($limit, $sort, $order);

        $view = $this->view(array('blocks' => $blocks));
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
    }

    /**
     * Update page
     *
     * @param Request $request
     * @param Block   $block
     *
     * @return Response
     */
    public function putAction(Request $request, Block $block)
    {
    }
}
