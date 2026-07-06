<?php

/**
 * Comment service test.
 */

namespace App\Tests\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Repository\CommentRepository;
use App\Service\CommentService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CommentServiceTest.
 */
class CommentServiceTest extends TestCase
{
    /**
     * Tests creating comment for photo.
     */
    public function testCreateForPhoto(): void
    {
        $user = $this->createMock(UserInterface::class);
        $user
            ->method('getUserIdentifier')
            ->willReturn('test@example.com');

        $photo = new Photo();
        $photo->setTitle('Test photo');
        $photo->setFilename('test.jpg');

        $comment = new Comment();

        $commentRepository = $this->createMock(CommentRepository::class);
        $commentRepository
            ->expects($this->once())
            ->method('save')
            ->with($comment);

        $service = new CommentService($commentRepository);
        $service->createForPhoto($comment, $photo, $user);

        $this->assertSame($photo, $comment->getPhoto());
        $this->assertSame('test@example.com', $comment->getEmail());
        $this->assertSame('test@example.com', $comment->getNick());
        $this->assertInstanceOf(\DateTimeImmutable::class, $comment->getCreatedAt());
    }
}
