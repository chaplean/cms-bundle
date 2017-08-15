<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Form\Type;

use Chaplean\Bundle\CmsBundle\Form\Type\PostType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class PostTypeTest.
 *
 * @package   Chaplean\Bundle\CmsBundle\Tests
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     7.0.0
 */
class PostTypeTest extends TypeTestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Form\Type\PostType::__construct()
     *
     * @return void
     */
    public function testContructWithoutArgument()
    {
        $postType = new PostType();

        $this->assertInstanceOf(PostType::class, $postType);
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Form\Type\PostType::buildForm()
     *
     * @return void
     */
    public function testSubmitEmptyData()
    {
        $form = $this->factory->create(PostType::class);

        $this->assertFalse($form->isValid());
    }
}
