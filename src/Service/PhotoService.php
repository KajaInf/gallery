<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Photo;
use App\Entity\Tag;
use App\Repository\CommentRepository;
use App\Repository\PhotoRepository;
use App\Repository\TagRepository;
use App\Service\Interface\PhotoServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Handles photo-related application logic.
 */
class PhotoService implements PhotoServiceInterface
{
    /**
     * Creates the photo service.
     */
    public function __construct(
        private readonly PhotoRepository $photoRepository,
        private readonly TagRepository $tagRepository,
        private readonly CommentRepository $commentRepository,
        private readonly EntityManagerInterface $entityManager,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir
    ) {
    }

    /**
     * Returns photos filtered by tag or all photos sorted by creation date.
     *
     * @return Photo[]
     */
    public function getPhotos(?string $tagId): array
    {
        if (null !== $tagId) {
            return $this->photoRepository->findByTagId((int) $tagId);
        }

        return $this->photoRepository->findBy([], ['createdAt' => 'DESC']);
    }

    /**
     * Returns selected tag by id.
     */
    public function getSelectedTag(?string $tagId): ?Tag
    {
        if (null === $tagId) {
            return null;
        }

        return $this->tagRepository->find((int) $tagId);
    }

    /**
     * Saves a photo.
     */
    public function save(Photo $photo): void
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    /**
     * Stores uploaded image file and assigns filename to photo.
     */
    public function uploadImage(Photo $photo, UploadedFile $imageFile): void
    {
        $newFilename = uniqid('photo_', true) . '.' . $imageFile->guessExtension();

        $imageFile->move(
            $this->projectDir . '/public/uploads/photos',
            $newFilename
        );

        $photo->setFilename($newFilename);
    }

    /**
     * Deletes a photo with related comments, tags and file.
     */
    public function delete(Photo $photo): void
    {
        foreach ($photo->getTags() as $tag) {
            $photo->removeTag($tag);
        }

        $comments = $this->commentRepository->findBy(['photo' => $photo]);

        foreach ($comments as $comment) {
            $this->entityManager->remove($comment);
        }

        $filePath = $this->projectDir . '/public/uploads/photos/' . $photo->getFilename();

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }

    /**
     * Returns comments assigned to a photo.
     *
     * @return Comment[]
     */
    public function getComments(Photo $photo): array
    {
        return $this->commentRepository->findBy(
            ['photo' => $photo],
            ['createdAt' => 'DESC']
        );
    }
}
