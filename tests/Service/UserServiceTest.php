<?php

/**
 * User service test.
 */

namespace App\Tests\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserServiceTest.
 */
class UserServiceTest extends TestCase
{
    /**
     * Tests getting all users.
     */
    public function testGetAll(): void
    {
        $users = [new User(), new User()];

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);

        $service = new UserService($repository, $hasher);

        $this->assertSame($users, $service->getAll());
    }

    /**
     * Tests saving user.
     */
    public function testSave(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('save')
            ->with($user);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);

        $service = new UserService($repository, $hasher);
        $service->save($user);
    }

    /**
     * Tests setting password.
     */
    public function testSetPassword(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);
        $hasher
            ->expects($this->once())
            ->method('hashPassword')
            ->with($user, 'secret123')
            ->willReturn('hashed-password');

        $service = new UserService($repository, $hasher);
        $service->setPassword($user, 'secret123');

        $this->assertSame('hashed-password', $user->getPassword());
    }

    /**
     * Tests updating password.
     */
    public function testUpdatePassword(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);
        $hasher
            ->expects($this->once())
            ->method('hashPassword')
            ->with($user, 'new-password')
            ->willReturn('new-hash');

        $service = new UserService($repository, $hasher);
        $service->updatePassword($user, 'new-password');

        $this->assertSame('new-hash', $user->getPassword());
    }

    /**
     * Tests update password with null password.
     */
    public function testUpdatePasswordWithNullDoesNothing(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);
        $hasher
            ->expects($this->never())
            ->method('hashPassword');

        $service = new UserService($repository, $hasher);
        $service->updatePassword($user, null);

        $this->assertNull($user->getPassword());
    }

    /**
     * Tests update password with empty password.
     */
    public function testUpdatePasswordWithEmptyStringDoesNothing(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);
        $hasher
            ->expects($this->never())
            ->method('hashPassword');

        $service = new UserService($repository, $hasher);
        $service->updatePassword($user, '');

        $this->assertNull($user->getPassword());
    }

    /**
     * Tests deleting user.
     */
    public function testDelete(): void
    {
        $user = new User();

        $repository = $this->createMock(UserRepository::class);
        $repository
            ->expects($this->once())
            ->method('delete')
            ->with($user);

        $hasher = $this->createMock(UserPasswordHasherInterface::class);

        $service = new UserService($repository, $hasher);
        $service->delete($user);
    }
}
