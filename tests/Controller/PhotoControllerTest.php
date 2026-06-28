<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Gallery;
use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PhotoControllerTest extends WebTestCase
{
    public function testPhotoIndexIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/photo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Lista zdjęć');
    }

    public function testPhotoIndexWithTagFilterIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/photo?tag=1');

        $this->assertResponseIsSuccessful();
    }

    public function testPhotoShowIsSuccessful(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gallery = new Gallery();
        $gallery->setTitle('Test gallery');

        $photo = new Photo();
        $photo->setTitle('Test photo');
        $photo->setDescription('Test photo description');
        $photo->setFilename('test.jpg');
        $photo->setGallery($gallery);
        $photo->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($gallery);
        $entityManager->persist($photo);
        $entityManager->flush();

        $client->request('GET', '/photo/'.$photo->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Test photo');
        $this->assertSelectorTextContains('body', 'Test photo description');
    }

    private function createAdminUser(): User
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('admin-photo-test-'.uniqid().'@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    public function testPhotoNewIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/photo/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    public function testPhotoEditIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gallery = new Gallery();
        $gallery->setTitle('Edit gallery');

        $photo = new Photo();
        $photo->setTitle('Edit photo');
        $photo->setDescription('Edit description');
        $photo->setFilename('edit.jpg');
        $photo->setGallery($gallery);
        $photo->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($gallery);
        $entityManager->persist($photo);
        $entityManager->flush();

        $client->loginUser($admin);
        $client->request('GET', '/photo/'.$photo->getId().'/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
}
