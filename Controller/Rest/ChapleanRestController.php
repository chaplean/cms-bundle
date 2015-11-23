<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ChapleanRestController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
abstract class ChapleanRestController extends FOSRestController
{
    /**
     * @param mixed $entity
     *
     * @return Response
     */
    public function delete($entity)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $success = true;
        $errors = array();
        try {
            $em->remove($entity);
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
     * @param Request $request
     * @param string  $entity
     * @param array   $group
     *
     * @return Response
     */
    public function getAll(Request $request, $entity, $group = null)
    {
        $limit = $request->query->get('limit', null);
        $sort  = $request->query->get('sort', null);
        $order = $request->query->get('order', null);

        $entityRepository = $this->getDoctrine()->getRepository($entity);

        if (method_exists($entityRepository, 'getAll')) {
            $entities = $entityRepository->getAll($limit, $sort, $order);
        } else {
            $entities = $entityRepository->findAll();
        }

        return $this->handleResponse($entities, $group);
    }

    /**
     * @param array|mixed $data
     * @param array       $group
     *
     * @return Response
     */
    public function handleResponse($data, $group = null)
    {
        $view = $this->view($data);

        if (!empty($group)) {
            $view->setSerializationContext(SerializationContext::create()->setGroups($group));
        }

        return $this->handleView($view);
    }
}
