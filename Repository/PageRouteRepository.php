<?php

namespace Chaplean\Bundle\CmsBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * PageRouteRepository.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PageRouteRepository extends CmsRepository
{
    /**
     * @return QueryBuilder
     */
    protected function buildQueryGetAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p, pu, ps');
        $qb->from('ChapleanCmsBundle:PageRoute', 'p');
        $qb->join('p.publication', 'pu');
        $qb->join('pu.status', 'ps');

        return $qb;
    }

    /**
     * @param string $sort
     *
     * @return string
     */
    protected function buildSort($sort)
    {
        $filters = array_merge(
            $this->getSortable(),
            [
                'id'         => 'p.id',
                'path'       => 'p.path',
                'menu'       => 'p.menuName',
                'rollover'   => 'p.rollover',
                'dateAdd'    => 'p.dateAdd',
                'dateUpdate' => 'p.dateUpdate'
            ]
        );

        return array_key_exists($sort, $filters) ? $filters[$sort] : null;
    }
}
