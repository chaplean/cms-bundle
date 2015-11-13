<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * RestPublicationStatusController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     2.0.0
 *
 * @Annotations\RouteResource("PublicationStatus")
 */
class RestPublicationStatusController extends FOSRestController
{
    /**
     * @param integer $id
     *
     * @return Response
     */
    public function getAction($id)
    {
        $publicationStatus = $this->getDoctrine()->getRepository('ChapleanCmsBundle:PublicationStatus')->find($id);

        $view = $this->view(array('publicationStatus' => $publicationStatus));
        $view->setSerializationContext(SerializationContext::create()->setGroups(
            array('publication_status_id', 'publication_status_keyname', 'publication_status_position')
        ));

        return $this->handleView($view);
    }

    /**
     * @return Response
     */
    public function getAllAction()
    {
        $publicationStatus = $this->getDoctrine()->getRepository('ChapleanCmsBundle:PublicationStatus')->findAll();

        $view = $this->view(array('publicationStatus' => $publicationStatus));
        $view->setSerializationContext(SerializationContext::create()->setGroups(
            array('publication_status_id', 'publication_status_keyname', 'publication_status_position')
        ));

        return $this->handleView($view);
    }
}
