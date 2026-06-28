<?php

namespace App\Tests\Controller;

use App\Entity\Gallery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class GalleryControllerTest extends WebTestCase
{
    public function testGalleryIndexIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testGalleryNewRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery/new');

        $this->assertResponseRedirects();
    }

    public function testGalleryShowIsSuccessful(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gallery = new Gallery();
        $gallery->setTitle('Test gallery');

        $entityManager->persist($gallery);
        $entityManager->flush();

        $client->request('GET', '/gallery/'.$gallery->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Test gallery');
    }

    private function createAdminUser(): User
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('admin-gallery-test-'.uniqid().'@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    public function testGalleryNewIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/gallery/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
}
