<?php

namespace Chaplean\Bundle\CmsBundle\Repository;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Utility\PostUtility;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

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

    /**
     * @param Post   $post
     * @param string $to
     *
     * @return void
     */
    public function castPostTo($post, $to)
    {
        $class = PostUtility::getClassByInstance($to);
        if (get_class($post) == $class) {
            return;
        }

        $id = $post->getId();
        $this->update($to, $id);
        if (is_subclass_of($class, get_class($post))) {
            $this->insert($class, $id);
        } elseif (get_parent_class($post) && get_parent_class($class) && get_parent_class($post) == get_parent_class($class)) {
            $this->remove($post, $id);
            $this->insert($class, $id);
        } elseif (get_parent_class($post) == $class) {
            $this->remove($post, $id);
        }

        $this->_em->flush();
    }

    /**
     * @param string  $class
     * @param integer $id
     *
     * @return void
     */
    public function remove($class, $id)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $this->_em->getClassMetadata(get_class($class));
        $query = 'DELETE FROM ' . $metadata->table['name'] . ' WHERE id = ' . $id;
        $this->_em->getConnection()->exec($query);
    }

    /**
     * @param string  $class
     * @param integer $id
     *
     * @return void
     */
    public function insert($class, $id)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $this->_em->getClassMetadata($class);
        $query = 'INSERT INTO ' . $metadata->table['name'] . ' VALUES (' . $id . ')';
        $this->_em->getConnection()->exec($query);
    }

    /**
     * @param string  $category
     * @param integer $id
     *
     * @return void
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update($category, $id)
    {
        $query = 'UPDATE cl_post SET category = \'' . $category . '\' WHERE id = ' . $id;
        $this->_em->getConnection()->exec($query);
    }
}