<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Entity\Media;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestMediaController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Media")
 */
class RestMediaController extends FOSRestController
{
    public function getAllAction(Request $request, Media $mediaId)
    {

    }

    public function postAction(Request $request, Media $mediaId)
    {

    }

    public function putAction(Request $request, Media $mediaId)
    {

    }

    public function deleteAction(Request $request, Media $mediaId)
    {

    }
}
