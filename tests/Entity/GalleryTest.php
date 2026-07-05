<?php

/**
 * Gallery entity test.
 */

namespace App\Tests\Entity;

use App\Entity\Gallery;
use PHPUnit\Framework\TestCase;

/**
 * Class GalleryTest.
 */
class GalleryTest extends TestCase
{
    /**
     * Tests getters and setters.
     */
    public function testGettersAndSetters(): void
    {
        $gallery = new Gallery();

        $gallery->setTitle('Moja galeria');

        $this->assertSame('Moja galeria', $gallery->getTitle());
        $this->assertNull($gallery->getId());
    }
}
