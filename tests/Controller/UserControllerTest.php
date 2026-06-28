<?php

/**
 * User controller test.
 */

namespace App\Tests\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserControllerTest.
 */
class UserControllerTest extends WebTestCase
{
    /**
     * Tests user index redirect for anonymous user.
     *
     * @return void
     */
    public function testUserIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/user');

        $this->assertResponseRedirects();
    }

    /**
     * Tests user index page for admin user.
     *
     * @return void
     */
    public function testUserIndexIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/user');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    /**
     * Tests user new page for admin user.
     *
     * @return void
     */
    public function testUserNewIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/user/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    /**
     * Tests user edit page for admin user.
     *
     * @return void
     */
    public function testUserEditIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('edited-user-'.uniqid().'@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        $client->loginUser($admin);
        $client->request('GET', '/user/'.$user->getId().'/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }

    /**
     * Creates admin user.
     *
     * @return User Admin user
     */
    private function createAdminUser(): User
    {
        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);

        $user = new User();
        $user->setEmail('admin-user-test-'.uniqid().'@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
