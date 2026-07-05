<?php

/**
 * Photo service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Gallery;
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
 * Class PhotoService.
 */
class PhotoService implements PhotoServiceInterface
{
    /**
     * Constructor.
     *
     * @param PhotoRepository        $photoRepository   Photo repository
     * @param TagRepository          $tagRepository     Tag repository
     * @param CommentRepository      $commentRepository Comment repository
     * @param EntityManagerInterface $entityManager     Entity manager
     * @param string                 $projectDir        Project directory
     */
    public function __construct(private readonly PhotoRepository $photoRepository, private readonly TagRepository $tagRepository, private readonly CommentRepository $commentRepository, private readonly EntityManagerInterface $entityManager, #[Autowire('%kernel.project_dir%')] private readonly string $projectDir)
    {
    }

    /**
     * Returns photos filtered by tag.
     *
     * @param string|null $tagId Tag identifier
     *
     * @return Photo[] List of photos
     */
    public function getPhotos(?string $tagId): array
    {
        if (null !== $tagId) {
            return $this->photoRepository->findByTagId((int) $tagId);
        }

        return $this->photoRepository->findBy([], ['createdAt' => 'DESC']);
    }

    /**
     * Returns selected tag.
     *
     * @param string|null $tagId Tag identifier
     *
     * @return Tag|null Tag entity
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
     *
     * @param Photo $photo Photo entity
     */
    public function save(Photo $photo): void
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    /**
     * Uploads photo image.
     *
     * @param Photo        $photo     Photo entity
     * @param UploadedFile $imageFile Uploaded image
     */
    public function uploadImage(Photo $photo, UploadedFile $imageFile): void
    {
        $newFilename = uniqid('photo_', true).'.'.$imageFile->guessExtension();

        $imageFile->move(
            $this->projectDir.'/public/uploads/photos',
            $newFilename
        );

        $photo->setFilename($newFilename);
    }

    /**
     * Deletes a photo.
     *
     * @param Photo $photo Photo entity
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

        $filePath = $this->projectDir.'/public/uploads/photos/'.$photo->getFilename();

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }

    /**
     * Returns comments for photo.
     *
     * @param Photo $photo Photo entity
     *
     * @return Comment[] List of comments
     */
    public function getComments(Photo $photo): array
    {
        return $this->commentRepository->findBy(
            ['photo' => $photo],
            ['createdAt' => 'DESC']
        );
    }

    /**
     * Returns gallery photos.
     *
     * @param Gallery $gallery Gallery entity
     *
     * @return Photo[] List of photos
     */
    public function getPhotosForGallery(Gallery $gallery): array
    {
        return $this->photoRepository->findBy(
            ['gallery' => $gallery],
            ['id' => 'DESC']
        );
    }
}
