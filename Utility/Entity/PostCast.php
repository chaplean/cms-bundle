<?php
namespace Chaplean\Bundle\CmsBundle\Utility\Entity;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * PostCast.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class PostCast
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * PostCast constructor.
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        $this->em = $registry->getManager();
    }

    /**
     * @param Post   $post
     * @param string $to
     *
     * @return void
     */
    public function castPostTo($post, $to)
    {
        $class = Post::getClassByInstance($to);
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

        $this->em->flush();
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
        $metadata = $this->em->getClassMetadata(get_class($class));
        $query = 'DELETE FROM ' . $metadata->table['name'] . ' WHERE id = ' . $id;
        $this->em->getConnection()->exec($query);
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
        $metadata = $this->em->getClassMetadata($class);
        $query = 'INSERT INTO ' . $metadata->table['name'] . ' VALUES (' . $id . ')';
        $this->em->getConnection()->exec($query);
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
        $this->em->getConnection()->exec($query);
    }
}
