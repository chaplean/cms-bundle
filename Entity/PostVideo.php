<?php

namespace Chaplean\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_post_video")
 */
class PostVideo extends Post
{
}
