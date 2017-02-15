<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Media;
use Chaplean\Bundle\CmsBundle\Entity\MediaImage;
use Chaplean\Bundle\CmsBundle\Entity\MediaPdf;
use Chaplean\Bundle\CmsBundle\Form\Type\MediaImageType;
use Chaplean\Bundle\CmsBundle\Form\Type\MediaPdfType;
use Chaplean\Bundle\CmsBundle\Utility\MediaUtility;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
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
    /**
     * @return Response
     */
    public function getAllAction()
    {
        $medias = $this->getDoctrine()
                       ->getRepository('ChapleanCmsBundle:Media')
                       ->findAll();
        $response = $this->view($medias);
        $context = new Context();
        $context->setGroups(array('media_all'));
        $response->setContext($context);
        if ($medias) {
            return $this->handleView($response);
        } else {
            return $this->handleView(new View('nothing to return', 404));
        }
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $files = $request->files;
        /** @var UploadedFile $uploadedMedia */
        $uploadedMedia = $files->get('file');

        if (!empty($uploadedMedia)) {
            if (!$uploadedMedia->isValid()) {
                return $this->handleView(new View('Invalid filename', 400));
            }

            /** @var MediaUtility $mediaUtility */
            $mediaUtility = $this->get('chaplean_cms.media_utility');
            $mediaUtility->setFile($uploadedMedia);
            $media = $mediaUtility->createMedia();

            if (!$media) {
                return $this->handleView(new View('Failed to upload media', 400));
            }

            $response = $this->view($media);
            $context = new Context();
            $context->setGroups(array('media_all'));
            $response->setContext($context);

            return $this->handleView($response);
        } else {
            return $this->handleView(new View('Nothing to upload', 400));
        }
    }

    /**
     * @param Request $request
     * @param Media   $mediaId
     *
     * @return void
     */
    public function putAction(Request $request, Media $mediaId)
    {
    }

    /**
     * @param \Chaplean\Bundle\CmsBundle\Entity\Media $media
     *
     * @return Response
     */
    public function deleteAction(Media $media)
    {
        if ($media) {
            $mediaUtility = $this->get('chaplean_cms.media_utility');
            $mediaUtility->setMedia($media);

            if ($mediaUtility->deleteMedia()) {
                return $this->handleView(new View());
            } else {
                return $this->handleView(new View('', 500));
            }
        } else {
            return $this->handleView(new View('media not found', 404));
        }
    }

    /**
     * Upload a logo for a structure
     *
     * @param Request $request
     * @param Media   $media
     *
     * @return Response
     */
    public function postEditAction(Request $request, Media $media)
    {
        if ($media) {
            $files = $request->files;
            /** @var UploadedFile $uploadedMedia */
            $uploadedMedia = $files->get('file');

            if (!empty($uploadedMedia)) {
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

            $form = null;
            if ($media instanceof MediaImage) {
                $form = $this->createForm(MediaImageType::class, $media);
            } elseif ($media instanceof MediaPdf) {
                $form = $this->createForm(MediaPdfType::class, $media);
            }

            if (!empty($form)) {
                $form->submit($request->request->all());
                if ($form->isValid()) {
                    $this->getDoctrine()->getManager()->persist($media);
                    $this->getDoctrine()->getManager()->flush();
                }
            }

            $response = $this->view($media);
            $context = new Context();
            $context->setGroups(array('media_all'));
            $response->setContext($context);

            return $this->handleView($response);
        } else {
            return $this->handleView(new View('media not found', 404));
        }
    }
}
