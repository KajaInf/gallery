<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
        $manager->persist($user);

        $natureTag = new Tag();
        $natureTag->setName('natura');
        $manager->persist($natureTag);

        $animalsTag = new Tag();
        $animalsTag->setName('zwierzęta');
        $manager->persist($animalsTag);

        $landscapeTag = new Tag();
        $landscapeTag->setName('krajobraz');
        $manager->persist($landscapeTag);

        $forestTag = new Tag();
        $forestTag->setName('las');
        $manager->persist($forestTag);

        $natureGallery = new Gallery();
        $natureGallery->setTitle('Galeria natury');
        $manager->persist($natureGallery);

        $animalsGallery = new Gallery();
        $animalsGallery->setTitle('Galeria zwierząt');
        $manager->persist($animalsGallery);







        $photosData = [
            [
                'title' => 'Las o poranku',
                'description' => 'Zdjęcie pokazujące las o poranku.',
                'filename' => 'forest.jpg',
                'gallery' => $natureGallery,
                'tags' => [$natureTag, $forestTag],
            ],
            [
                'title' => 'Górski krajobraz',
                'description' => 'Widok na góry i niebo.',
                'filename' => 'mountains.jpg',
                'gallery' => $natureGallery,
                'tags' => [$natureTag, $landscapeTag],
            ],
            [
                'title' => 'Jezioro',
                'description' => 'Spokojne jezioro wśród natury.',
                'filename' => 'lake.jpg',
                'gallery' => $natureGallery,
                'tags' => [$natureTag, $landscapeTag],
            ],
            [
                'title' => 'Ścieżka w lesie',
                'description' => 'Leśna ścieżka pokazująca działanie tagu las.',
                'filename' => 'path.jpg',
                'gallery' => $natureGallery,
                'tags' => [$natureTag, $forestTag],
            ],
            [
                'title' => 'Kot',
                'description' => 'Zdjęcie kota w galerii zwierząt.',
                'filename' => 'cat.jpg',
                'gallery' => $animalsGallery,
                'tags' => [$animalsTag],
            ],
            [
                'title' => 'Pies',
                'description' => 'Zdjęcie psa w galerii zwierząt.',
                'filename' => 'dog.jpg',
                'gallery' => $animalsGallery,
                'tags' => [$animalsTag],
            ],
            [
                'title' => 'Sowa',
                'description' => 'Sowa jako przykład zdjęcia ze zwierzętami i naturą.',
                'filename' => 'owl.jpg',
                'gallery' => $animalsGallery,
                'tags' => [$animalsTag, $natureTag],
            ],
            [
                'title' => 'Lis w lesie',
                'description' => 'Lis pokazujący kilka tagów jednocześnie.',
                'filename' => 'fox.jpg',
                'gallery' => $animalsGallery,
                'tags' => [$animalsTag, $forestTag, $natureTag],
            ],
        ];

        foreach ($photosData as $index => $photoData) {
            $photo = new Photo();
            $photo->setTitle($photoData['title']);
            $photo->setDescription($photoData['description']);
            $photo->setFilename($photoData['filename']);
            $photo->setGallery($photoData['gallery']);
            $photo->setCreatedAt(new \DateTimeImmutable('-'.($index + 1).' days'));

            foreach ($photoData['tags'] as $tag) {
                $photo->addTag($tag);
            }

            $manager->persist($photo);


            $comment = new Comment();
            $comment->setNick('Użytkownik testowy');
            $comment->setEmail('user@example.com');
            $comment->setContent('Przykładowy komentarz do zdjęcia: '.$photoData['title']);
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setPhoto($photo);

            $manager->persist($comment);
        }

        $manager->flush();
    }
}
