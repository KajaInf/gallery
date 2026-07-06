<?php

/**
 * Comment controller test.
 */

namespace App\Tests\Controller;

use App\Entity\Comment;
use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class CommentControllerTest.
 */
class CommentControllerTest extends WebTestCase
{
    /**
     * Tests comment index redirect for anonymous user.
     */
    public function testCommentIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/comment');

        $this->assertResponseRedirects();
    }

    /**
     * Tests comment index page for admin user.
     */
    public function testCommentIndexIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $client->loginUser($admin);
        $client->request('GET', '/comment');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    /**
     * Tests comment show page for admin user.
     */
    public function testCommentShowIsSuccessfulForAdmin(): void
    {
        $client = static::createClient();
        $admin = $this->createAdminUser();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);

        $gallery = new Gallery();
        $gallery->setTitle('Comment gallery');

        $photo = new Photo();
        $photo->setTitle('Comment photo');
        $photo->setFilename('comment.jpg');
        $photo->setGallery($gallery);
        $photo->setCreatedAt(new \DateTimeImmutable());

        $comment = new Comment();
        $comment->setNick('Tester');
        $comment->setEmail('tester@example.com');
        $comment->setContent('Test comment content');
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setPhoto($photo);

        $entityManager->persist($gallery);
        $entityManager->persist($photo);
        $entityManager->persist($comment);
        $entityManager->flush();

        $client->loginUser($admin);
        $client->request('GET', '/comment/' . $comment->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Test comment content');
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
        $user->setEmail('admin-comment-test-' . uniqid() . '@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($passwordHasher->hashPassword($user, 'password'));

        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }
}
