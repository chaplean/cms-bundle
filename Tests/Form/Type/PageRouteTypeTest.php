<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Form\Type;

use Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class PageRouteTypeTest.
 *
 * @package   Chaplean\Bundle\CmsBundle\Tests
 * @author    Tom - Chaplean <tom@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     7.0.0
 */
class PageRouteTypeTest extends TypeTestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Form\Type\PageRouteType::buildForm()
     *
     * @return void
     */
    public function testSubmitEmptyData()
    {
        // We have to test the form validity in Controllers cause it is impossible here
        @self::markTestSkipped('There is no way to properly test EntityType for now. See: https://github.com/symfony/symfony/issues/15098');

        $form = $this->factory->create(PageRouteType::class);

        $this->assertFalse($form->isValid());
    }
}
