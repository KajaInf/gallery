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
     * @param PhotoRepository   $photoRepository   Photo repository
     * @param TagRepository     $tagRepository     Tag repository
     * @param CommentRepository $commentRepository Comment repository
     * @param string            $projectDir        Project directory
     */
    public function __construct(private readonly PhotoRepository $photoRepository, private readonly TagRepository $tagRepository, private readonly CommentRepository $commentRepository, #[Autowire('%kernel.project_dir%')] private readonly string $projectDir)
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

        return $this->photoRepository->findAllWithRelations();
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
        $this->photoRepository->save($photo);
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
        $filePath = $this->projectDir.'/public/uploads/photos/'.$photo->getFilename();

        if (is_file($filePath)) {
            unlink($filePath);
        }

        $this->photoRepository->delete($photo);
    }

    /**
     * Returns comments for photo.
     *
     * @param Photo $photo  Photo entity
     * @param int   $limit  Results limit
     * @param int   $offset Results offset
     *
     * @return Comment[] List of comments
     */
    public function getComments(Photo $photo, int $limit, int $offset): array
    {
        return $this->commentRepository->findByPhoto($photo, $limit, $offset);
    }

    /**
     * Counts comments for photo.
     *
     * @param Photo $photo Photo entity
     *
     * @return int Number of comments
     */
    public function countComments(Photo $photo): int
    {
        return $this->commentRepository->countByPhoto($photo);
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
