<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\ORM;

use Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFileExtensionImageData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\ORM
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
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
        $datas = [
            ['png', 'image/png'],
            ['bmp', 'image/bmp'],
            ['gif', 'image/gif'],
            ['ico', 'image/x-icon'],
            ['jpg', 'image/jpeg'],
        ];

        foreach ($datas as $data) {
            $image = new FileExtensionImage();
            $image->setExtension($data[0]);
            $image->setMimeType($data[1]);

            $manager->persist($image);
        }

        $manager->flush();
    }
}
