<?php

/**
 * User service interface.
 */

namespace App\Service\Interface;

use App\Entity\User;

/**
 * Interface UserServiceInterface.
 */
interface UserServiceInterface
{
    /**
     * Returns all users.
     *
     * @return User[] List of users
     */
    public function getAll(): array;

    /**
     * Saves a user.
     *
     * @param User $user User entity
     *
     * @return void
     */
    public function save(User $user): void;

    /**
     * Sets hashed password.
     *
     * @param User   $user          User entity
     * @param string $plainPassword Plain password
     *
     * @return void
     */
    public function setPassword(User $user, string $plainPassword): void;

    /**
     * Updates password.
     *
     * @param User        $user          User entity
     * @param string|null $plainPassword Plain password
     *
     * @return void
     */
    public function updatePassword(User $user, ?string $plainPassword): void;

    /**
     * Deletes a user.
     *
     * @param User $user User entity
     *
     * @return void
     */
    public function delete(User $user): void;
}
