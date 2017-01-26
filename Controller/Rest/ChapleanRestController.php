<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Debug\Exception\UndefinedMethodException;
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
        list($limit, $sort , $order) = $this->getLimitOrderParamters($request);

        $entityRepository = $this->getDoctrine()->getRepository($entity);

        if (method_exists($entityRepository, 'getAll')) {
            $entities = $entityRepository->getAll($limit, $sort, $order);
        } else {
            $entities = $entityRepository->findAll();
        }

        return $this->handleResponse($entities, $group);
    }

    /**
     * @param Request $request
     * @param string  $entity
     * @param array   $group
     *
     * @return Response
     * @throws UndefinedMethodException
     */
    public function getAllActive(Request $request, $entity, $group = null)
    {
        list($limit, $sort , $order) = $this->getLimitOrderParamters($request);

        $em = $this->getDoctrine()->getManager();
        $entityRepository = $em->getRepository($entity);

        if (method_exists($entityRepository, 'getAllActive')) {
            $entities = $entityRepository->getAllActive($limit, $sort, $order);
        } else {
            throw new UndefinedMethodException(sprintf('%s not implement \'getAllActive\'', get_class($entityRepository)), new \ErrorException());
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
            $view->setContext(Context::create()->setGroups($group));
        }

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getLimitOrderParamters($request)
    {
        return array($request->query->get('limit', null), $request->query->get('sort', null), $request->query->get('order', null));
    }
}
