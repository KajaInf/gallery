<?php

namespace App\Service\Interface;

use App\Entity\User;

/**
 * Provides user-related application operations.
 */
interface UserServiceInterface
{
    /**
     * Returns all users.
     *
     * @return User[]
     */
    public function getAll(): array;

    /**
     * Saves a user.
     */
    public function save(User $user): void;

    /**
    * Hashes and saves user password when a plain password is required.
    */
    public function setPassword(User $user, string $plainPassword): void;

    /**
     * Updates user password when a new plain password is provided.
     */
    public function updatePassword(User $user, ?string $plainPassword): void;

    /**
     * Deletes a user.
     */
    public function delete(User $user): void;
}
