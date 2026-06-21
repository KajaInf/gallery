<?php

namespace App\Tests\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TagControllerTest extends WebTestCase
{
    public function testTagIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tag');

        $this->assertResponseRedirects();
    }

    public function testTagNewRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tag/new');

        $this->assertResponseRedirects();
    }
    public function testTagShowRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $tag = new Tag();
        $tag->setName('Test tag');

        $entityManager->persist($tag);
        $entityManager->flush();

        $client->request('GET', '/tag/' . $tag->getId());

        $this->assertResponseRedirects();
    }
    private function createAdminUser(): User
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('admin-tag-test-' . uniqid() . '@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
    public function testTagIndexIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/tag');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }
}
