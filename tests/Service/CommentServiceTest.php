<?php

namespace App\Tests\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Service\CommentService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentServiceTest extends TestCase
{
    public function testCreateForPhoto(): void
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager
            ->expects($this->once())
            ->method('persist');

        $entityManager
            ->expects($this->once())
            ->method('flush');

        $user = $this->createMock(UserInterface::class);
        $user
            ->method('getUserIdentifier')
            ->willReturn('test@example.com');

        $photo = new Photo();
        $photo->setTitle('Test photo');
        $photo->setFilename('test.jpg');

        $comment = new Comment();

        $commentRepository = $this->createMock(\App\Repository\CommentRepository::class);
        $service = new CommentService($commentRepository, $entityManager);
        $service->createForPhoto($comment, $photo, $user);

        $this->assertSame($photo, $comment->getPhoto());
        $this->assertSame('test@example.com', $comment->getEmail());
        $this->assertSame('test@example.com', $comment->getNick());
        $this->assertInstanceOf(\DateTimeImmutable::class, $comment->getCreatedAt());
    }
}
