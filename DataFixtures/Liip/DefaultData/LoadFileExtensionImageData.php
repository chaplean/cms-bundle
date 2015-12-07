<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFileExtensionImageData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class LoadFileExtensionImageData extends AbstractFixture
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $datas = array(
            '1'  => array('png', 'image/png'),
        );

        foreach ($datas as $data) {
            $image = new FileExtensionImage();
            $image->setExtension($data[0]);
            $image->setMimeType($data[1]);

            $manager->persist($image);
            $this->setReference('file-extension-image-' . $data[0], $image);
        }

        $manager->flush();
    }
}
