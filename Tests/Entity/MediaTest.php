<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Entity;

use Chaplean\Bundle\CmsBundle\Entity\MediaImage;
use Chaplean\Bundle\CmsBundle\Entity\MediaPdf;
use PHPUnit\Framework\TestCase;

/**
 * MediaTest.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     3.3.0
 */
class MediaTest extends TestCase
{
    /**
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Media::__construct()
     * @covers \Chaplean\Bundle\CmsBundle\Entity\Media::getInstanceOf()
     *
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
