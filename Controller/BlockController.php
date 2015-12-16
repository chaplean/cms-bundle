<?php

namespace Chaplean\Bundle\CmsBundle\Controller;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Chaplean\Bundle\CmsBundle\Form\Type\BlockType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * BlockController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class BlockController extends Controller
{
    /**
     * Edit action
     *
     * @param Integer $blockId Block Id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($blockId = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var EntityRepository $blockRepository */
        $blockRepository = $em->getRepository('ChapleanCmsBundle:Block');

        /** @var Block $block */
        $block = ($blockId !== null) ? $blockRepository->find($blockId) : null;

        if ($blockId !== null && $block == null) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm(BlockType::class);

        return $this->render(
            'ChapleanCmsBundle:Back/Block:edit.html.twig',
            array(
                'blockId' => ($block !== null) ? $block->getId() : null,
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Return pages list
     *
     * @return Response
     */
    public function listAction()
    {
        return $this->render('ChapleanCmsBundle:Back/Block:list.html.twig');
    }
}
