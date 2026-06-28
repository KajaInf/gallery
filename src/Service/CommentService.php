<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Repository\CommentRepository;
use App\Service\Interface\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Handles comment-related application logic.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Creates the comment service.
     */
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Returns all comments.
     *
     * @return Comment[]
     */
    public function getAll(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * Saves a comment.
     */
    public function save(Comment $comment): void
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    /**
     * Deletes a comment.
     */
    public function delete(Comment $comment): void
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    /**
     * Creates a comment assigned to a photo and user.
     */
    public function createForPhoto(Comment $comment, Photo $photo, UserInterface $user): void
    {
        $comment->setPhoto($photo);
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setEmail($user->getUserIdentifier());
        $comment->setNick($user->getUserIdentifier());

        $this->save($comment);
    }
}
