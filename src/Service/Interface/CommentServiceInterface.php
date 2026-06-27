<?php

namespace App\Service\Interface;

use App\Entity\Comment;
use App\Entity\Photo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Provides comment-related application operations.
 */
interface CommentServiceInterface
{
    /**
     * Returns all comments.
     *
     * @return Comment[]
     */
    public function getAll(): array;

    /**
     * Saves a comment.
     */
    public function save(Comment $comment): void;

    /**
     * Deletes a comment.
     */
    public function delete(Comment $comment): void;

    /**
     * Creates a comment assigned to a photo and user.
     */
    public function createForPhoto(Comment $comment, Photo $photo, UserInterface $user): void;
}
