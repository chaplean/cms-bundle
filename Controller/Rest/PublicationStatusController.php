<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\PublicationStatus;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\Request;
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
class PublicationStatusController extends ChapleanRestController
{
    /**
     * @param PublicationStatus $publicationStatus
     *
     * @return Response
     */
    public function getAction(PublicationStatus $publicationStatus)
    {
        return $this->handleResponse($publicationStatus, array(
            'publication_status_id', 'publication_status_keyname', 'publication_status_position'
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        return $this->getAll($request, 'ChapleanCmsBundle:PublicationStatus', array(
            'publication_status_id', 'publication_status_keyname', 'publication_status_position'
        ));
    }
}
