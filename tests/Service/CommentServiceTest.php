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
     * Tests getting all comments.
     */
    public function testGetAll(): void
    {
        $comments = [new Comment(), new Comment()];

        $repository = $this->createMock(CommentRepository::class);
        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($comments);

        $service = new CommentService($repository);

        $this->assertSame($comments, $service->getAll());
    }

    /**
     * Tests saving comment.
     */
    public function testSave(): void
    {
        $comment = new Comment();

        $repository = $this->createMock(CommentRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with($comment);

        $service = new CommentService($repository);
        $service->save($comment);
    }

    /**
     * Tests deleting comment.
     */
    public function testDelete(): void
    {
        $comment = new Comment();

        $repository = $this->createMock(CommentRepository::class);
        $repository
            ->expects($this->once())
            ->method('delete')
            ->with($comment);

        $service = new CommentService($repository);
        $service->delete($comment);
    }

    /**
     * Tests creating comment for user.
     */
    public function testCreateForUser(): void
    {
        $user = $this->createMock(UserInterface::class);
        $user
            ->method('getUserIdentifier')
            ->willReturn('test@example.com');

        $repository = $this->createMock(CommentRepository::class);
        $service = new CommentService($repository);

        $comment = $service->createForUser($user);

        $this->assertSame('test@example.com', $comment->getEmail());
        $this->assertSame('test@example.com', $comment->getNick());
    }

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

        $repository = $this->createMock(CommentRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with($comment);

        $service = new CommentService($repository);
        $service->createForPhoto($comment, $photo, $user);

        $this->assertSame($photo, $comment->getPhoto());
        $this->assertSame('test@example.com', $comment->getEmail());
        $this->assertSame('test@example.com', $comment->getNick());
        $this->assertInstanceOf(\DateTimeImmutable::class, $comment->getCreatedAt());
    }

    /**
     * Tests paginated comments.
     */
    public function testGetPaginatedForPhoto(): void
    {
        $photo = new Photo();

        $comments = [
            new Comment(),
            new Comment(),
        ];

        $repository = $this->createMock(CommentRepository::class);

        $repository
            ->expects($this->once())
            ->method('findByPhoto')
            ->with($photo, 10, 10)
            ->willReturn($comments);

        $repository
            ->expects($this->once())
            ->method('countByPhoto')
            ->with($photo)
            ->willReturn(25);

        $service = new CommentService($repository);

        $result = $service->getPaginatedForPhoto($photo, 2);

        $this->assertSame($comments, $result['comments']);
        $this->assertSame(2, $result['currentPage']);
        $this->assertSame(3, $result['totalPages']);
    }

    /**
     * Tests that page number cannot be lower than one.
     */
    public function testGetPaginatedForPhotoUsesFirstPageForInvalidPage(): void
    {
        $photo = new Photo();

        $repository = $this->createMock(CommentRepository::class);

        $repository
            ->expects($this->once())
            ->method('findByPhoto')
            ->with($photo, 10, 0)
            ->willReturn([]);

        $repository
            ->expects($this->once())
            ->method('countByPhoto')
            ->with($photo)
            ->willReturn(0);

        $service = new CommentService($repository);

        $result = $service->getPaginatedForPhoto($photo, 0);

        $this->assertSame(1, $result['currentPage']);
        $this->assertSame(0, $result['totalPages']);
    }
}
