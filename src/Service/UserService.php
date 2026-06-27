<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Interface\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Handles user-related application logic.
 */
class UserService implements UserServiceInterface
{
    /**
     * Creates the user service.
     */
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    /**
     * Returns all users.
     *
     * @return User[]
     */
    public function getAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * Saves a user.
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * Updates user password when a new plain password is provided.
     */
    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if (null === $plainPassword || '' === $plainPassword) {
            return;
        }

        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $plainPassword)
        );
    }

    /**
     * Deletes a user.
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
