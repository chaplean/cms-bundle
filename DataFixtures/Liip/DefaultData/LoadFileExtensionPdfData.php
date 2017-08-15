<?php

namespace Chaplean\Bundle\CmsBundle\DataFixtures\Liip\DefaultData;

use Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf;
use Chaplean\Bundle\UnitBundle\Utility\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFileExtensionPdfData.
 *
 * @package   Chaplean\Bundle\CmsBundle\DataFixtures\Liip
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     1.0.0
 */
class LoadFileExtensionPdfData extends AbstractFixture
{
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $datas = array(
            '1'  => array('pdf', 'application/pdf'),
        );

        foreach ($datas as $data) {
            $pdf = new FileExtensionPdf();
            $pdf->setExtension($data[0]);
            $pdf->setMimeType($data[1]);

            $manager->persist($pdf);
            $this->setReference('file-extension-pdf-' . $data[0], $pdf);
        }

        $manager->flush();
    }
}
