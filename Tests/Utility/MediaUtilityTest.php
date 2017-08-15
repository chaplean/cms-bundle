<?php

namespace Tests\Chaplean\Bundle\CmsBundle\Utility;

use Chaplean\Bundle\CmsBundle\Entity\FileExtensionImage;
use Chaplean\Bundle\CmsBundle\Entity\FileExtensionPdf;
use Chaplean\Bundle\CmsBundle\Utility\MediaUtility;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * MediaUtilityTest.php.
 *
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2015 Chaplean (http://www.chaplean.coop)
 * @since     3.3.0
 */
class MediaUtilityTest extends TestCase
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $rootDir;

    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->registry = \Mockery::mock(RegistryInterface::class);
        $this->logger = \Mockery::mock(LoggerInterface::class);
        $this->repository = \Mockery::mock(ObjectRepository::class);
        $this->em = \Mockery::mock(EntityManagerInterface::class);

        $this->rootDir = __DIR__ . '/..';

        $this->em->shouldReceive('persist')
            ->zeroOrMoreTimes()
            ->andReturnNull();

        $this->em->shouldReceive('remove')
            ->zeroOrMoreTimes()
            ->andReturnNull();

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
        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturnNull();

        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionPdf());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionImage());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);


        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionPdf());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);


        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $this->assertFileExists($mediaUtility->getPublicDir() . $media->getPath());
    }

    /**
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::setFile()
     * @covers \Chaplean\Bundle\CmsBundle\Utility\MediaUtility::createMedia()
     *
     * @return void
     */
    public function testCreateMediaImage()
    {
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionImage());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);


        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $this->assertFileExists($mediaUtility->getPublicDir() . $media->getPath());
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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionPdf());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);


        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty2.pdf', 'test-empty2.pdf', null, null, null, true));
        $updatedMedia = $mediaUtility->updateMedia();

        $this->assertNotNull($updatedMedia);
        $this->assertFileExists($mediaUtility->getPublicDir() . $updatedMedia->getPath());
        $this->assertEquals($media, $updatedMedia);
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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionImage());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image2.png', 'test-image2.png', null, null, null, true));
        $updatedMedia = $mediaUtility->updateMedia();

        $this->assertNotNull($updatedMedia);
        $this->assertFileExists($mediaUtility->getPublicDir() . $updatedMedia->getPath());
        $this->assertEquals($media->getId(), $updatedMedia->getId());
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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionPdf());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-empty.pdf', 'test-empty.pdf', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $mediaUtility->setMedia($media);
        $mediaUtility->deleteMedia();

        $this->assertFileNotExists($mediaUtility->getPublicDir() . $media->getPath());
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
        $this->repository->shouldReceive('findOneBy')
            ->zeroOrMoreTimes()
            ->andReturn(new FileExtensionImage());

        $this->em->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->repository);

        $this->registry->shouldReceive('getManager')
            ->once()
            ->andReturn($this->em);

        $mediaUtility = new MediaUtility($this->registry, $this->logger, $this->rootDir, false);

        $mediaUtility->setFile(new UploadedFile('Tests/Resources/test-image.png', 'test-image.png', null, null, null, true));

        $media = $mediaUtility->createMedia();

        $mediaUtility->setMedia($media);
        $mediaUtility->deleteMedia();

        $this->assertFileNotExists($mediaUtility->getPublicDir() . $media->getPath());
    }
}
