<?php

/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Interface\UserServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    /**
     * Constructor.
     *
     * @param UserRepository              $userRepository User repository
     * @param UserPasswordHasherInterface $passwordHasher Password hasher
     */
    public function __construct(private readonly UserRepository $userRepository, private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * Returns all users.
     *
     * @return User[] List of users
     */
    public function getAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * Saves a user.
     *
     * @param User $user User entity
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * Sets hashed password.
     *
     * @param User   $user          User entity
     * @param string $plainPassword Plain password
     */
    public function setPassword(User $user, string $plainPassword): void
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $plainPassword)
        );
    }

    /**
     * Updates password.
     *
     * @param User        $user          User entity
     * @param string|null $plainPassword Plain password
     */
    public function updatePassword(User $user, ?string $plainPassword): void
    {
        if (null === $plainPassword || '' === $plainPassword) {
            return;
        }

        $this->setPassword($user, $plainPassword);
    }

    /**
     * Deletes a user.
     *
     * @param User $user User entity
     */
    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }
}
