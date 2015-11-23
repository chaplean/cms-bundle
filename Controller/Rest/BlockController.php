<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Rest;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use FOS\RestBundle\Controller\Annotations;
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
    }
}
