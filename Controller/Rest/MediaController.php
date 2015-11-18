<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Media;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MediaController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Media")
 */
class MediaController extends FOSRestController
{
    public function getAllAction()
    {
        $medias = $this->getDoctrine()->getRepository('ChapleanCmsBundle:Media')->findAll();

        if ($medias) {
            return $this->handleView(new View($medias));
        } else {
            return $this->handleView(new View('nothing to return', 404));
        }
    }

    public function postAction(Request $request, Media $mediaId)
    {

    }

    public function putAction(Request $request, Media $mediaId)
    {

    }

    public function deleteAction(Media $mediaId)
    {
        $media = $this->getDoctrine()->getRepository('ChapleanCmsBundle:Media')->findBy($mediaId);

        if ($media) {
            $this->getDoctrine()->getManager()->remove($media);
            return $this->handleView(new View());
        } else {
            return $this->handleView(new View('nothing to return', 404));
        }
    }
}
