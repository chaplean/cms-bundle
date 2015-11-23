<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\MediaImage;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMediaImageData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class LoadMediaImageData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $now = new \DateTime('now');

        $datas = array(
            '1'  => array('test_path_image_1', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '2'  => array('test_path_image_2', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '3'  => array('test_path_image_3', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '4'  => array('test_path_image_4', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '5'  => array('test_path_image_5', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '6'  => array('test_path_image_6', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '7'  => array('test_path_image_7', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '8'  => array('test_path_image_8', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
            '9'  => array('test_path_image_9', 'test_file_name_png', '42', $now, $now, 'file-extension-image-png', 400, 300, 'test_image', 'test_image_alt'),
        );

        foreach ($datas as $key => $data) {
            $image = new MediaImage();
            $image->setPath($data[0]);
            $image->setFileName($data[1]);
            $image->setFileWeight($data[2]);
            $image->setDateAdd($data[3]);
            $image->setDateUpdated($data[4]);
            $image->setExtension($this->getReference($data[5]));
            $image->setWidth($data[6]);
            $image->setHeight($data[7]);
            $image->setTitle($data[8]);
            $image->setAlternativeTitle($data[9]);

            $manager->persist($image);
            $this->setReference('media-image-' . $key, $image);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            'Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData\LoadFileExtensionImageData'
        );
    }
}
