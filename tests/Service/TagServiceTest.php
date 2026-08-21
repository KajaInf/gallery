<?php

/**
 * Tag service test.
 */

namespace App\Tests\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\TagService;
use PHPUnit\Framework\TestCase;

/**
 * Class TagServiceTest.
 */
class TagServiceTest extends TestCase
{
    /**
     * Tests getting all tags.
     */
    public function testGetAll(): void
    {
        $tags = [new Tag(), new Tag()];

        $repository = $this->createMock(TagRepository::class);
        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($tags);

        $service = new TagService($repository);

        $this->assertSame($tags, $service->getAll());
    }

    /**
     * Tests saving tag.
     */
    public function testSave(): void
    {
        $tag = new Tag();

        $repository = $this->createMock(TagRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with($tag);

        $service = new TagService($repository);
        $service->save($tag);
    }

    /**
     * Tests deleting tag.
     */
    public function testDelete(): void
    {
        $tag = new Tag();

        $repository = $this->createMock(TagRepository::class);
        $repository
            ->expects($this->once())
            ->method('delete')
            ->with($tag);

        $service = new TagService($repository);
        $service->delete($tag);
    }
}
