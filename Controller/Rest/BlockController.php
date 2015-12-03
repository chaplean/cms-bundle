<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Chaplean\Bundle\CmsBundle\Entity\Publication;
use Chaplean\Bundle\CmsBundle\Form\Type\BlockType;
use Chaplean\Bundle\CmsBundle\Utility\ErrorFormUtility;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlockController.
 *
 * @package   Chaplean\Bundle\CmsBundle\Controller\Rest
 * @author    Benoit - Chaplean <benoit@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 *
 * @Annotations\RouteResource("Block")
 */
class BlockController extends ChapleanRestController
{
    /**
     * Delete block
     *
     * @param Block $block
     *
     * @return Response
     */
    public function deleteAction(Block $block)
    {
        return $this->delete($block);
    }

    /**
     * Get one block
     *
     * @param Block $block
     *
     * @return Response
     */
    public function getAction(Block $block)
    {
        return $this->handleResponse($block, array(
            'block_all', 'publication_all', 'publication_status_id',
            'publication_status_keyname', 'publication_status_position'
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getAllAction(Request $request)
    {
        return $this->getAll($request, 'ChapleanCmsBundle:Block', array(
            'block_all', 'publication_all', 'publication_status_id',
            'publication_status_keyname', 'publication_status_position'
        ));
    }

    /**
     * Save block
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
        $formBlock = $this->createForm(new BlockType());

        // bind data in form
        $formBlock->submit($request->request->all());

        if ($formBlock->isValid()) {
            try {
                /** @var Block $block */
                $block = $formBlock->getData();
                /** @var Publication $publication */
                $publication = $block->getPublication();
                $publication->setDateAdd(new \DateTime());
                $publication->setIsHighlighted(false);
                $em->persist($publication);
                $em->flush();

                $block->setPublication($publication);
                $block->setDateAdd(new \DateTime());
                $em->persist($block);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Block create failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($block, array(
                'block_all', 'publication_all', 'publication_status_id',
                'publication_status_keyname', 'publication_status_position',
            ));
        }

        return $this->handleView($this->view(ErrorFormUtility::getErrorsForAngular($formBlock->getErrors(true), $formBlock->getName()), 400));
    }

    /**
     * Update block
     *
     * @param Request $request
     * @param Block   $block
     *
     * @return Response
     */
    public function putAction(Request $request, Block $block)
    {
        /** @var Logger $logger */
        $logger = $this->get('logger');
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if (empty($block)) {
            return $this->handleView($this->view('Block not found', 404));
        }

        // create form and get params
        $formBlock = $this->createForm(new BlockType(), $block);

        // bind data in form
        $formBlock->submit($request->request->all());

        if ($formBlock->isValid()) {
            try {
                /** @var Block $block */
                $block = $formBlock->getData();

                $block->setDateUpdate(new \DateTime());

                $em->persist($block);
                $em->flush();
            } catch (\Exception $e) {
                $logger->error(sprintf('%s : %', __FUNCTION__, $e->getMessage()));

                return $this->handleView($this->view('Block update failed : ' . $e->getMessage(), 400));
            }

            return $this->handleResponse($block, array(
                'block_all', 'publication_all', 'publication_status_id',
                'publication_status_keyname', 'publication_status_position',
            ));
        }

        return $this->handleView($this->view(ErrorFormUtility::getErrorsForAngular($formBlock->getErrors(true), $formBlock->getName()), 400));
    }
}
