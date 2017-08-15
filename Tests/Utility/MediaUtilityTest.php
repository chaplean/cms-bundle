<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Entity\Media;
use Chaplean\Bundle\CmsBundle\Utility\MediaUtility;
use Chaplean\Bundle\UnitBundle\Test\LogicalTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * MediaUtilityTest.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     3.3.0
 */
class MediaUtilityTest extends LogicalTestCase
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        @copy('Tests/Resources/empty.pdf', 'Tests/Resources/test-empty.pdf');
        @copy('Tests/Resources/empty2.pdf', 'Tests/Resources/test-empty2.pdf');
        @copy('Tests/Resources/image.png', 'Tests/Resources/test-image.png');
        @copy('Tests/Resources/image2.png', 'Tests/Resources/test-image2.png');
    }
    
    /**
     * @return void
     */
    public function tearDown()
    {
        @unlink('Tests/Resources/test-empty.pdf');
        @unlink('Tests/Resources/test-empty2.pdf');
        @unlink('Tests/Resources/test-image.png');
        @unlink('Tests/Resources/test-image2.png');
        @array_map('unlink', glob('web/medias/*'));
        
        parent::tearDown();
    }

    /**
     * @return void
     */
    public function testInstanciate()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $this->assertInstanceOf('Chaplean\Bundle\CmsBundle\Utility\MediaUtility', $mediaUtility);
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::getUploadedFileExtension()
     *
     * @return void
     */
    public function testUploadedFileExtensionPdf()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf'));
        
        $fileExtension = $mediaUtility->getUploadedFileExtension();
        $this->assertInstanceOf('Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf', $fileExtension);
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::getUploadedFileExtension()
     *
     * @return void
     */
    public function testUploadedFileExtensionImage()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png'));

        $fileExtension = $mediaUtility->getUploadedFileExtension();
        $this->assertInstanceOf('Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage', $fileExtension);
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     *
     * @return void
     */
    public function testCreateMediaPdf()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();

        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());
        
        $this->assertNotNull($addedMedia);
        $this->assertFileExists('web/' . $addedMedia->getPath());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     *
     * @return void
     */
    public function testCreateMediaImage()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();
        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());

        $this->assertNotNull($addedMedia);
        $this->assertFileExists('web/' . $addedMedia->getPath());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::updateMedia()
     *
     * @return void
     */
    public function testUpdateMediaPdf()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();
        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());
        $addedMediaId = $addedMedia->getId();

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty2.pdf', 'test-empty2.pdf', null, null, null, true));
        $updatedMedia = $mediaUtility->updateMedia();
        $this->em->flush();
        
        $this->assertNotNull($updatedMedia);
        $this->assertFileExists('web/' . $updatedMedia->getPath());
        $this->assertEquals($addedMediaId, $updatedMedia->getId());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::updateMedia()
     *
     * @return void
     */
    public function testUpdateMediaImage()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();
        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());
        $addedMediaId = $addedMedia->getId();

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image2.png', 'test-image2.png', null, null, null, true));
        $updatedMedia = $mediaUtility->updateMedia();
        $this->em->flush();

        $this->assertNotNull($updatedMedia);
        $this->assertFileExists('web/' . $updatedMedia->getPath());
        $this->assertEquals($addedMediaId, $updatedMedia->getId());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::deleteMedia()
     *
     * @return void
     */
    public function testDeleteMediaPdf()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();
        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());
        $addedMediaId = $addedMedia->getId();

        $mediaUtility->setMedia($addedMedia);
        $mediaUtility->deleteMedia();
        $this->em->flush();

        $this->assertFileNotExists('web/' . $addedMedia->getPath());
        $this->assertNull($this->em->find('ChapleanCmsBundle:Media', $addedMediaId));
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::deleteMedia()
     *
     * @return void
     */
    public function testDeleteMediaImage()
    {
        /** @var MediaUtility $mediaUtility */
        $mediaUtility = $this->getContainer()->get('chaplean_cms.media_utility');
        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();
        $this->em->flush();

        /** @var Media $addedMedia */
        $addedMedia = $this->em->find('ChapleanCmsBundle:Media', $media->getId());
        $addedMediaId = $addedMedia->getId();

        $mediaUtility->setMedia($addedMedia);
        $mediaUtility->deleteMedia();
        $this->em->flush();

        $this->assertFileNotExists('web/' . $addedMedia->getPath());
        $this->assertNull($this->em->find('ChapleanCmsBundle:Media', $addedMediaId));
    }
}
