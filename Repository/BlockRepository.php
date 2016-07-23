<?php

namespace Chaplean\Bundle\CmsBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * BlockRepository.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class BlockRepository extends CmsRepository
{
    /**
     * @return QueryBuilder
     */
    protected function buildQueryGetAll()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('b, pu, ps');
        $qb->from('ChapleanCmsBundle:Block', 'b');
        $qb->join('b.publication', 'pu');
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
        $filters = array(
            'id'                   => 'b.id',
            'name'                 => 'b.name',
            'dateAdd'              => 'b.dateAdd',
            'dateUpdate'           => 'b.dateUpdate',
            'datePublicationBegin' => 'pu.datePublicationBegin',
            'datePublicationEnd'   => 'pu.datePublicationEnd',
        );

        return array_key_exists($sort, $filters) ? $filters[$sort] : null;
    }
}
