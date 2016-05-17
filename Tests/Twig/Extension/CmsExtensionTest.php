<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Twig\Extension;

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

        $this->cmsExtension = $this->getContainer()->get('chaplean_cms.cms_extension');
    }

    /**
     * @return void
     */
    public function testGetGlobals()
    {
        $this->assertEquals(
            $this->cmsExtension->getGlobals(),
            array(
                'access_debug'      => false,
                'cms_front_layout'  => 'ChapleanCmsBundle::layout-frontoffice.html.twig',
                'cms_front_route'   => 'cms_back_index',
                'cms_logo_path'     => '',
                'block_is_activate' => true,
                'post_is_activate'  => true,
                'page_is_activate'  => true,
                'media_is_activate' => true,
                'cms_action'        => array(
                    'block' => array('add', 'remove'),
                    'page'  => array('add', 'remove'),
                    'post'  => array('add', 'duplicate', 'remove'),
                )
            )
        );
    }

    /**
     * @return void
     */
    public function testGetName()
    {
        $this->assertEquals($this->cmsExtension->getName(), 'chaplean_cms_twig_extension');
    }
}
