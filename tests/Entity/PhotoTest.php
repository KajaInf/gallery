<?php

/**
 * Photo entity test.
 */

namespace App\Tests\Entity;

use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

/**
 * Class PhotoTest.
 */
class PhotoTest extends TestCase
{
    /**
     * Tests getters and setters.
     *
     * @return void
     */
    public function testGettersAndSetters(): void
    {
        $photo = new Photo();

        $photo->setTitle('Kruk');
        $photo->setFilename('kruk.jpg');

        $gallery = new Gallery();
        $gallery->setTitle('Ptaki');

        $photo->setGallery($gallery);

        $this->assertSame('Kruk', $photo->getTitle());
        $this->assertSame('kruk.jpg', $photo->getFilename());
        $this->assertSame($gallery, $photo->getGallery());
    }

    /**
     * Tests tag collection.
     *
     * @return void
     */
    public function testTags(): void
    {
        $photo = new Photo();

        $tag = new Tag();
        $tag->setName('natura');

        $photo->addTag($tag);

        $this->assertCount(1, $photo->getTags());
        $this->assertTrue($photo->getTags()->contains($tag));

        $photo->removeTag($tag);

        $this->assertCount(0, $photo->getTags());
    }
}
