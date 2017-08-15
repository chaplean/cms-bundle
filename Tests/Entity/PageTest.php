<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Entity;

use Chaplean\Bundle\CmsBundle\Entity\Page;
use PHPUnit\Framework\TestCase;

/**
 * PageTest.php.
 *
 * @author    Valentin - Chaplean <valentin@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class PageTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::setContent()
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::getImageSource()
     *
     * @return void
     */
    public function testGetImageSource()
    {
        $page = new Page();
        $page->setContent(
            '<p><img style="width: 50%;" src="/media/1" title="BDD" alt="TEST bdd" height="163" width="532"/></p><p>Page-zoom-5-content</p><p><br/></p><p>TEST TEST TEST <br/></p><p><br/></p>'
        );

        $this->assertEquals('/media/1', $page->getImageSource());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::getImageSource()
     *
     * @return void
     */
    public function testGetImageSourceOnEmptyContent()
    {
        $page = new Page();

        $this->assertEquals('', $page->getImageSource());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::setContent()
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::getStripContent()
     *
     * @return void
     */
    public function testGetStripContent()
    {
        $page = new Page();
        $page->setContent(
            '<p><img style="width: 50%;" src="/media/1" title="BDD" alt="TEST bdd" height="163" width="532"/></p><p>Page-zoom-5-content</p><p><br/></p><p>TEST TEST TEST <br/></p><p><br/></p>'
        );

        $this->assertEquals('Page-zoom-5-content TEST TEST TEST', $page->getStripContent());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Page::getStripContent()
     *
     * @return void
     */
    public function testGetStripContentOnEmptyContent()
    {
        $page = new Page();

        $this->assertEquals('', $page->getStripContent());
    }
}
