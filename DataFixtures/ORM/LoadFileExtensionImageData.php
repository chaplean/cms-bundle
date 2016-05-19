<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\ORM;

use Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFileExtensionImageData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\ORM
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
            array('png', 'image/png'),
            array('bmp', 'image/bmp'),
            array('gif', 'image/gif'),
            array('ico', 'image/x-icon'),
            array('jpg', 'image/jpeg'),
        );

        foreach ($datas as $data) {
            $image = new FileExtensionImage();
            $image->setExtension($data[0]);
            $image->setMimeType($data[1]);

            $manager->persist($image);
        }

        $manager->flush();
    }
}
