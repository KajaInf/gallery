<?php

/**
 * Gallery service test.
 */

namespace App\Tests\Service;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;
use App\Service\GalleryService;
use PHPUnit\Framework\TestCase;

/**
 * Class GalleryServiceTest.
 */
class GalleryServiceTest extends TestCase
{
    /**
     * Tests getting all galleries.
     */
    public function testGetAll(): void
    {
        $galleries = [new Gallery(), new Gallery()];

        $repository = $this->createMock(GalleryRepository::class);
        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($galleries);

        $service = new GalleryService($repository);

        $this->assertSame($galleries, $service->getAll());
    }

    /**
     * Tests saving gallery.
     */
    public function testSave(): void
    {
        $gallery = new Gallery();

        $repository = $this->createMock(GalleryRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with($gallery);

        $service = new GalleryService($repository);
        $service->save($gallery);
    }

    /**
     * Tests deleting empty gallery.
     */
    public function testCanDeleteEmptyGallery(): void
    {
        $gallery = new Gallery();

        $repository = $this->createMock(GalleryRepository::class);
        $repository
            ->expects($this->once())
            ->method('countPhotos')
            ->with($gallery)
            ->willReturn(0);

        $service = new GalleryService($repository);

        $this->assertTrue($service->canDelete($gallery));
    }

    /**
     * Tests gallery containing photos cannot be deleted.
     */
    public function testCannotDeleteGalleryWithPhotos(): void
    {
        $gallery = new Gallery();

        $repository = $this->createMock(GalleryRepository::class);
        $repository
            ->expects($this->once())
            ->method('countPhotos')
            ->with($gallery)
            ->willReturn(2);

        $service = new GalleryService($repository);

        $this->assertFalse($service->canDelete($gallery));
    }

    /**
     * Tests deleting gallery.
     */
    public function testDelete(): void
    {
        $gallery = new Gallery();

        $repository = $this->createMock(GalleryRepository::class);
        $repository
            ->expects($this->once())
            ->method('delete')
            ->with($gallery);

        $service = new GalleryService($repository);
        $service->delete($gallery);
    }
}
