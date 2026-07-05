<?php

/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Repository\CommentRepository;
use App\Service\Interface\CommentServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CommentService.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Constructor.
     *
     * @param CommentRepository      $commentRepository Comment repository
     * @param EntityManagerInterface $entityManager     Entity manager
     */
    public function __construct(private readonly CommentRepository $commentRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * Returns all comments.
     *
     * @return Comment[] List of comments
     */
    public function getAll(): array
    {
        return $this->commentRepository->findAll();
    }

    /**
     * Saves a comment.
     *
     * @param Comment $comment Comment entity
     */
    public function save(Comment $comment): void
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    /**
     * Deletes a comment.
     *
     * @param Comment $comment Comment entity
     */
    public function delete(Comment $comment): void
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    /**
     * Creates a comment assigned to a photo and user.
     *
     * @param Comment       $comment Comment entity
     * @param Photo         $photo   Photo entity
     * @param UserInterface $user    User entity
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
