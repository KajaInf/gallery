<?php

/**
 * User entity test.
 */

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest.
 */
class UserTest extends TestCase
{
    /**
     * Tests getters and setters.
     */
    public function testGettersAndSetters(): void
    {
        $user = new User();

        $user->setEmail('test@example.com');
        $user->setPassword('hashed-password');
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertSame('test@example.com', $user->getEmail());
        $this->assertSame('test@example.com', $user->getUserIdentifier());
        $this->assertSame('hashed-password', $user->getPassword());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
        $this->assertContains('ROLE_USER', $user->getRoles());
        $this->assertNull($user->getId());
    }

    /**
     * Tests that user always has ROLE_USER.
     */
    public function testUserAlwaysHasRoleUser(): void
    {
        $user = new User();

        $user->setRoles([]);

        $this->assertContains('ROLE_USER', $user->getRoles());
    }
}
