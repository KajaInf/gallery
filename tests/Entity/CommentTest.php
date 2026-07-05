<?php

/**
 * Comment entity test.
 */

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Photo;
use PHPUnit\Framework\TestCase;

/**
 * Class CommentTest.
 */
class CommentTest extends TestCase
{
    /**
     * Tests getters and setters.
     */
    public function testGettersAndSetters(): void
    {
        $comment = new Comment();

        $createdAt = new \DateTimeImmutable();
        $photo = new Photo();
        $photo->setTitle('Kruk');
        $photo->setFilename('kruk.jpg');

        $comment->setNick('test@example.com');
        $comment->setEmail('test@example.com');
        $comment->setContent('Bardzo ładne zdjęcie.');
        $comment->setCreatedAt($createdAt);
        $comment->setPhoto($photo);

        $this->assertSame('test@example.com', $comment->getNick());
        $this->assertSame('test@example.com', $comment->getEmail());
        $this->assertSame('Bardzo ładne zdjęcie.', $comment->getContent());
        $this->assertSame($createdAt, $comment->getCreatedAt());
        $this->assertSame($photo, $comment->getPhoto());
        $this->assertNull($comment->getId());
    }
}
