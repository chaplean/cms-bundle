<?php

namespace Chaplean\Bundle\CmsBundle\Repository;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * PostRepository.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostRepository extends CmsRepository
{
    /**
     * @param string  $category
     * @param integer $limit
     * @param string  $sort
     * @param string  $order
     *
     * @return Post[]
     */
    public function getByCategory($category, $limit = null, $sort = null, $order = null)
    {
        $qb = $this->buildQueryGetAll();

        $qb = $this->buildParam($qb, $limit, $sort, $order);
        if (!empty($category)) {
            $qb->andWhere('p INSTANCE OF :category');
            $qb->setParameter('category', $category);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    protected function buildQueryGetAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p, pu, ps');
        $qb->from('ChapleanCmsBundle:Post', 'p');
        $qb->join('p.publication', 'pu');
        $qb->join('pu.status', 'ps');

        return $qb;
    }

    /**
     * @param string $sort
     *
     * @return null|string
     */
    protected function buildSort($sort)
    {
        $filters = array_merge(
            $this->getSortable(),
            array(
                'id'         => 'p.id',
                'dateAdd'    => 'p.dateAdd',
                'dateUpdate' => 'p.dateUpdate',
            )
        );

        return array_key_exists($sort, $filters) ? $filters[$sort] : null;
    }
}
