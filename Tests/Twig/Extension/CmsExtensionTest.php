<?php

namespace Chaplean\Bundle\CmsBundle\Tests\Twig\Extension;

use Chaplean\Bundle\CmsBundle\Twig\Extension\CmsExtension;
use Chaplean\Bundle\UnitBundle\Test\LogicalTest;

/**
 * CmsExtensionTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class CmsExtensionTest extends LogicalTest
{
    /**
     * @var CmsExtension
     */
    private $cmsExtension;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->cmsExtension = new CmsExtension(array('front_layout' => 'foo'));
    }

    /**
     * @return void
     */
    public function testGetGlobals()
    {
        $this->assertEquals($this->cmsExtension->getGlobals(), array('cms_front_layout' => 'foo'));
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $this->assertEquals($this->cmsExtension->getName(), 'chaplean_cms_twig_extension');
    }
}
