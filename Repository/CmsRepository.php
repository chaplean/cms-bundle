<?php
/**
 * CmsRepository.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     X.Y.Z
 */

namespace Chaplean\Bundle\CmsBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

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
     * @param QueryBuilder $qb
     * @param integer      $limit
     * @param string       $sort
     * @param string       $order
     *
     * @return mixed
     */
    protected function buildParam($qb, $limit = null, $sort = null, $order = null)
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
        return array(
            'title'                => 'p.page.title',
            'subtitle'             => 'p.page.subtitle',
            'metaDescription'      => 'p.page.metaDescription',
            'datePublicationBegin' => 'pu.datePublicationBegin',
            'datePublicationEnd'   => 'pu.datePublicationEnd',
        );
    }

    /**
     * @param string $sort
     *
     * @return string
     */
    abstract protected function buildSort($sort);
}
