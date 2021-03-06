<?php

namespace Chaplean\Bundle\CmsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * CmsRepository.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
abstract class CmsRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    abstract protected function buildQueryGetAll();

    /**
     * @param integer $limit
     * @param string  $sort
     * @param string  $order
     *
     * @return mixed[]
     */
    public function getAll($limit = null, $sort = null, $order = null)
    {
        $qb = $this->buildQueryGetAll();

        return $this->buildParam($qb, $limit, $sort, $order)->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function getAllActive()
    {
        $qb = $this->buildQueryGetAll();
        $qb->where($qb->expr()->eq('ps.keyname', $qb->expr()->literal('published')));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $qb
     * @param integer      $limit
     * @param string       $sort
     * @param string       $order
     *
     * @return QueryBuilder
     */
    protected function buildParam(QueryBuilder $qb, $limit = null, $sort = null, $order = null)
    {
        if (!empty($limit)) {
            $qb->setMaxResults($limit);
        }

        $sort = $this->buildSort($sort);
        if (!empty($order) && !empty($sort)) {
            $qb->orderBy($sort, $order);
        }

        return $qb;
    }

    /**
     * @return array
     */
    protected function getSortable()
    {
        return [
            'title'                => 'p.page.title',
            'subtitle'             => 'p.page.subtitle',
            'metaDescription'      => 'p.page.metaDescription',
            'datePublicationBegin' => 'pu.datePublicationBegin',
            'datePublicationEnd'   => 'pu.datePublicationEnd',
        ];
    }

    /**
     * @param string $sort
     *
     * @return string
     */
    abstract protected function buildSort($sort);
}
