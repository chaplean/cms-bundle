<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Twig\Extension;

use Chaplean\Bundle\CmsBundle\Twig\Extension\CmsExtension;
use PHPUnit\Framework\TestCase;

/**
 * CmsExtensionTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class CmsExtensionTest extends TestCase
{
    /**
     * @var CmsExtension
     */
    private $cmsExtension;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->cmsExtension = new CmsExtension(
            [
                'access_debug' => false,
                'modules'      => [
                    'block' => ['add', 'remove'],
                    'post'  => ['action' => ['add', 'duplicate', 'remove']],
                    'page'  => ['add', 'remove'],
                    'media' => true,
                ],
                'template'     => [
                    'back_layout'  => 'ChapleanCmsBundle::layout-backoffice.html.twig',
                    'front_layout' => 'ChapleanCmsBundle::layout-frontoffice.html.twig',
                    'front_route'  => 'cms_back_index',
                    'logo_path'    => ''
                ]
            ]
        );
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Twig\Extension\CmsExtension::getGlobals()
     *
     * @return void
     */
    public function testGetGlobals()
    {
        $this->assertEquals(
            $this->cmsExtension->getGlobals(),
            [
                'access_debug'      => false,
                'cms_back_layout'   => 'ChapleanCmsBundle::layout-backoffice.html.twig',
                'cms_front_layout'  => 'ChapleanCmsBundle::layout-frontoffice.html.twig',
                'cms_front_route'   => 'cms_back_index',
                'cms_logo_path'     => '',
                'block_is_activate' => true,
                'post_is_activate'  => true,
                'page_is_activate'  => true,
                'media_is_activate' => true,
                'cms_action'        => [
                    'block' => ['add', 'remove'],
                    'page'  => ['add', 'remove'],
                    'post'  => ['add', 'duplicate', 'remove'],
                ]
            ]
        );
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Twig\Extension\CmsExtension::getName()
     *
     * @return void
     */
    public function testGetName()
    {
        $this->assertEquals($this->cmsExtension->getName(), 'chaplean_cms_twig_extension');
    }
}
