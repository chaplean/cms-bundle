<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Media;
use Chaplean\Bundle\CmsBundle\Utility\MediaUtility;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $response = $this->view($medias);
        $response->setSerializationContext(SerializationContext::create()->setGroups(array('media_all')));
        if ($medias) {
            return $this->handleView($response);
        } else {
            return $this->handleView(new View('nothing to return', 404));
        }
    }

    public function postAction(Request $request)
    {
        if (!empty($request->files)) {
            $files = $request->files;

            /** @var UploadedFile $uploadedMedia */
            $uploadedMedia = $files->get('file');

            if (!$uploadedMedia->isValid()) {
                return $this->handleView(new View('Invalid filename', 400));
            }

            /** @var MediaUtility $mediaUtility */
            $mediaUtility = $this->get('chaplean_cms.media_utility');
            $mediaUtility->setFile($uploadedMedia);
            $media = $mediaUtility->createMedia();

            if (!$media) {
                return $this->handleView(new View('Failed to upload media', 500));
            }

            $response = $this->view($media);
            $response->setSerializationContext(SerializationContext::create()->setGroups(array('media_all')));
            return $this->handleView($response);
        } else {
            return $this->handleView(new View('Nothing to upload', 400));
        }
    }

    public function putAction(Request $request, Media $mediaId)
    {

    }

    public function deleteAction(Media $media)
    {
        if ($media) {
            $mediaUtility = $this->get('chaplean_cms.media_utility');
            $mediaUtility->setMedia($media);

            if ($mediaUtility->deleteMedia()) {
                return $this->handleView(new View());
            } else {
                return $this->handleView(new View('Unable to delete related file on disk', 500));
            }
        } else {
            return $this->handleView(new View('media not found', 404));
        }
    }

    /**
     * Upload a logo for a structure
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postEditAction(Request $request, Media $media)
    {
        if ($media) {
            if (!empty($request->files)) {
                $files = $request->files;

                /** @var UploadedFile $uploadedMedia */
                $uploadedMedia = $files->get('file');

                if (!$uploadedMedia->isValid()) {
                    return $this->handleView(new View('Invalid filename', 400));
                }
                /** @var MediaUtility $mediaUtility */
                $mediaUtility = $this->get('chaplean_cms.media_utility');
                $mediaUtility->setFile($uploadedMedia);
                $mediaUtility->setMedia($media);
                $media = $mediaUtility->updateMedia();

                if (!$media) {
                    return $this->handleView(new View('Failed to upload media', 500));
                }
            }

            $response = $this->view($media);
            $response->setSerializationContext(SerializationContext::create()->setGroups(array('media_all')));
            return $this->handleView($response);
        } else {
            return $this->handleView(new View('media not found', 404));
        }
    }
}
