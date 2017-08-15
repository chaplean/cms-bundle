<?php

namespace Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Entity\Post;
use Chaplean\Bundle\CmsBundle\Entity\PostTestimonial;
use Chaplean\Bundle\CmsBundle\Entity\PostVideo;
use Chaplean\Bundle\CmsBundle\Entity\PostZoom;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 * PostCast.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PostUtility
{
    /**
     * @return array
     */
    public static function getAvailableInstance()
    {
        return array(
            Post::class            => 'news',
            PostVideo::class       => 'video',
            PostTestimonial::class => 'testimonial',
            PostZoom::class        => 'zoom',
        );
    }

    /**
     * @param string $post
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public static function getClassByInstance($post)
    {
        $class = array_search($post, self::getAvailableInstance());

        if ($class !== false) {
            return $class;
        } else {
            throw new InvalidArgumentException(sprintf('Not defined %s type for post.', $post));
        }
    }
}
