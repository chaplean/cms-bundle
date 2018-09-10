<?php

namespace Chaplean\Bundle\CmsBundle\Controller\Back;

use Chaplean\Bundle\CmsBundle\Entity\Block;
use Chaplean\Bundle\CmsBundle\Form\Type\BlockType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BlockController.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class BlockController extends Controller
{
    /**
     * New action
     *
     * @Route("/administration/block", name="cms_block_new")
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function newAction()
    {
        return $this->editAction(null);
    }

    /**
     * Edit action
     *
     * @Route("/administration/block/{blockId}", name="cms_block_edit", requirements={"blockId" = "\d+"})
     *
     * @param integer $blockId Block Id
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
            [
                'blockId' => ($block !== null) ? $block->getId() : null,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Return pages list
     *
     * @Route("/administration/blocks", name="cms_block_list")
     *
     * @return Response
     */
    public function listAction()
    {
        return $this->render('ChapleanCmsBundle:Back/Block:list.html.twig');
    }
}
