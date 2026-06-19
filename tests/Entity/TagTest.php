<?php

namespace App\Tests\Entity;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $tag = new Tag();

        $tag->setName('natura');

        $this->assertSame('natura', $tag->getName());
        $this->assertNull($tag->getId());
    }
}
