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
            '1'  => array('test_path_pdf_1',  'pdf_1',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '2'  => array('test_path_pdf_2',  'pdf_2',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '3'  => array('test_path_pdf_3',  'pdf_3',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '4'  => array('test_path_pdf_4',  'pdf_4',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '5'  => array('test_path_pdf_5',  'pdf_5',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '6'  => array('test_path_pdf_6',  'pdf_6',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '7'  => array('test_path_pdf_7',  'pdf_7',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '8'  => array('test_path_pdf_8',  'pdf_8',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '9'  => array('test_path_pdf_9',  'pdf_9',  '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '10' => array('test_path_pdf_10', 'pdf_10', '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '11' => array('test_path_pdf_11', 'pdf_11', '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
            '12' => array('test_path_pdf_12', 'pdf_12', '42', $now, $now, 'file-extension-pdf-pdf', 'test_pdf'),
        );

        foreach ($datas as $key => $data) {
            $pdf = new MediaPdf();
            $pdf->setIsPublic(true);
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
