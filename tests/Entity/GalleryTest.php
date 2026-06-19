<?php

namespace App\Tests\Entity;

use App\Entity\Gallery;
use PHPUnit\Framework\TestCase;

class GalleryTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $gallery = new Gallery();

        $gallery->setTitle('Moja galeria');

        $this->assertSame('Moja galeria', $gallery->getTitle());
        $this->assertNull($gallery->getId());
    }
}
