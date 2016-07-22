<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Entity;

use Chaplean\Bundle\CmsBundle\Entity\MediaImage;
use Chaplean\Bundle\CmsBundle\Entity\MediaPdf;
use Chaplean\Bundle\UnitBundle\Test\LogicalTestCase;

/**
 * MediaTest.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     3.3.0
 */
class MediaTest extends LogicalTestCase
{
    /**
     * @return void
     */
    public function testGetInstanceOf()
    {
        $mediaImage = new MediaImage();

        $this->assertEquals('image', $mediaImage->getInstanceOf());

        $mediaPdf = new MediaPdf();

        $this->assertEquals('pdf', $mediaPdf->getInstanceOf());
    }
}
