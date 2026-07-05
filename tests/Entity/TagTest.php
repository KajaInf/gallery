<?php

/**
 * Tag entity test.
 */

namespace App\Tests\Entity;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

/**
 * Class TagTest.
 */
class TagTest extends TestCase
{
    /**
     * Tests getters and setters.
     */
    public function testGettersAndSetters(): void
    {
        $tag = new Tag();

        $tag->setName('natura');

        $this->assertSame('natura', $tag->getName());
        $this->assertNull($tag->getId());
    }
}
