<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\MediaPdf;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadMediaPdfData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Matthias - Chaplean <matthias@chaplean.com>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.com)
 * @since     1.0.0
 */
class LoadMediaPdfData extends AbstractFixture implements DependentFixtureInterface
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
            '1'  => array('test_path_pdf_1', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '2'  => array('test_path_pdf_2', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '3'  => array('test_path_pdf_3', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '4'  => array('test_path_pdf_4', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '5'  => array('test_path_pdf_5', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '6'  => array('test_path_pdf_6', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '7'  => array('test_path_pdf_7', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '8'  => array('test_path_pdf_8', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
            '9'  => array('test_path_pdf_9', 'test_file_name_pdf', '42', $now, $now, 'file-extension-pdf-pdf', 'test_image'),
        );

        foreach ($datas as $key => $data) {
            $pdf = new MediaPdf();
            $pdf->setPath($data[0]);
            $pdf->setFileName($data[1]);
            $pdf->setFileWeight($data[2]);
            $pdf->setDateAdd($data[3]);
            $pdf->setDateUpdated($data[4]);
            $pdf->setExtension($this->getReference($data[5]));
            $pdf->setTitle($data[6]);

            $manager->persist($pdf);
            $this->setReference('media-pdf-' . $key, $pdf);
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
            'Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData\LoadFileExtensionPdfData'
        );
    }
}
