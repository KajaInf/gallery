<?php

/**
 * App fixtures test.
 */

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

/**
 * Class AppFixturesTest.
 */
class AppFixturesTest extends TestCase
{
    /**
     * Tests loading example data.
     *
     * @return void
     */
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

        $users = array_filter($persistedObjects, static fn (object $object): bool => $object instanceof User);
        $galleries = array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Gallery);
        $tags = array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Tag);
        $photos = array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Photo);
        $comments = array_filter($persistedObjects, static fn (object $object): bool => $object instanceof Comment);

        $this->assertNotEmpty($users);
        $this->assertNotEmpty($galleries);
        $this->assertNotEmpty($tags);
        $this->assertNotEmpty($photos);
        $this->assertNotEmpty($comments);
    }
}
