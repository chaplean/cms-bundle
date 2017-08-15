<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Form\Type;

use Chaplean\Bundle\CmsBundle\Form\Type\PageType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class PageTypeTest.
 *
 * @package   Chaplean\Bundle\CmsBundle\Tests
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     7.0.0
 */
class PageTypeTest extends TypeTestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Form\Type\PageType::buildForm()
     *
     * @return void
     */
    public function testSubmitEmptyData()
    {
        $form = $this->factory->create(PageType::class);

        $this->assertFalse($form->isValid());
    }
}
