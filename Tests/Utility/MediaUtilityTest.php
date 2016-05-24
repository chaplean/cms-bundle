<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\UnitBundle\Test\LogicalTest;

/**
 * MediaUtilityTest.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     3.3.0
 */
class MediaUtilityTest extends LogicalTest
{
    public function testInstanciate()
    {
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $this->assertInstanceOf('Chaplean\Bundle\CmsBundle\Utility\MediaUtility', $mediaUtility);
    }
}
