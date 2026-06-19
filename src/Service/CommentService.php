<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function createForPhoto(Comment $comment, Photo $photo, UserInterface $user): void
    {
        $comment->setPhoto($photo);
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setEmail($user->getUserIdentifier());
        $comment->setNick($user->getUserIdentifier());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }
}
