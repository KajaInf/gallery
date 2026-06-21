<?php

namespace App\Tests\DataFixtures;

use App\DataFixtures\AppFixtures;
use App\Entity\Comment;
use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixturesTest extends TestCase
{
    public function testLoadCreatesExampleData(): void
    {
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher
            ->method('hashPassword')
            ->willReturn('hashed-password');

        $fixtures = new AppFixtures($passwordHasher, dirname(__DIR__, 2));

        $manager = $this->createMock(ObjectManager::class);

        $persistedObjects = [];

        $manager
            ->method('persist')
            ->willReturnCallback(static function (object $object) use (&$persistedObjects): void {
                $persistedObjects[] = $object;
            });

        $manager
            ->expects($this->once())
            ->method('flush');

        $fixtures->load($manager);

        $this->assertCount(24, $persistedObjects);

        $this->assertNotEmpty(array_filter($persistedObjects, static fn (object $object): bool => $object instanceof User));
        $this->assertNotEmpty(array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Gallery));
        $this->assertNotEmpty(array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Tag));
        $this->assertNotEmpty(array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Photo));
        $this->assertNotEmpty(array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Comment));
    }
}
