<?php

/**
 * Comment service interface.
 */

namespace App\Service\Interface;

use App\Entity\Comment;
use App\Entity\Photo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface CommentServiceInterface.
 */
interface CommentServiceInterface
{
    /**
     * Returns all comments.
     *
     * @return Comment[] List of comments
     */
    public function getAll(): array;

    /**
     * Saves a comment.
     *
     * @param Comment $comment Comment entity
     *
     * @return void
     */
    public function save(Comment $comment): void;

    /**
     * Deletes a comment.
     *
     * @param Comment $comment Comment entity
     *
     * @return void
     */
    public function delete(Comment $comment): void;

    /**
     * Creates a comment assigned to a photo and user.
     *
     * @param Comment       $comment Comment entity
     * @param Photo         $photo   Photo entity
     * @param UserInterface $user    User entity
     *
     * @return void
     */
    public function createForPhoto(Comment $comment, Photo $photo, UserInterface $user): void;
}
