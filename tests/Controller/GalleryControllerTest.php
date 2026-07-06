<?php

/**
 * Gallery controller test.
 */

namespace App\Tests\Controller;

use App\Entity\Gallery;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class GalleryControllerTest.
 */
class GalleryControllerTest extends WebTestCase
{
    /**
     * Tests gallery index page.
     */
    public function testGalleryIndexIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    /**
     * Tests gallery new redirect for anonymous user.
     */
    public function testGalleryNewRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery/new');

        $this->assertResponseRedirects();
    }

    /**
     * Tests gallery show page.
     */
    public function testGalleryShowIsSuccessful(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gallery = new Gallery();
        $gallery->setTitle('Test gallery');

        $entityManager->persist($gallery);
        $entityManager->flush();

        $client->request('GET', '/gallery/' . $gallery->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Test gallery');
    }

    /**
     * Tests gallery new page for admin user.
     */
    public function testGalleryNewIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/gallery/new');

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
        $user->setEmail('admin-gallery-test-' . uniqid() . '@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
