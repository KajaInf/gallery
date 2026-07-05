<?php

/**
 * Photo service interface.
 */

namespace App\Service\Interface;

use App\Entity\Gallery;
use App\Entity\Photo;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface PhotoServiceInterface.
 */
interface PhotoServiceInterface
{
    /**
     * Returns photos filtered by tag.
     *
     * @param string|null $tagId Tag identifier
     *
     * @return Photo[] List of photos
     */
    public function getPhotos(?string $tagId): array;

    /**
     * Returns selected tag.
     *
     * @param string|null $tagId Tag identifier
     *
     * @return Tag|null Tag entity
     */
    public function getSelectedTag(?string $tagId): ?Tag;

    /**
     * Saves a photo.
     *
     * @param Photo $photo Photo entity
     */
    public function save(Photo $photo): void;

    /**
     * Uploads image for photo.
     *
     * @param Photo        $photo     Photo entity
     * @param UploadedFile $imageFile Uploaded image
     */
    public function uploadImage(Photo $photo, UploadedFile $imageFile): void;

    /**
     * Deletes a photo.
     *
     * @param Photo $photo Photo entity
     */
    public function delete(Photo $photo): void;

    /**
     * Returns photo comments.
     *
     * @param Photo $photo Photo entity
     *
     * @return array List of comments
     */
    public function getComments(Photo $photo): array;

    /**
     * Returns gallery photos.
     *
     * @param Gallery $gallery Gallery entity
     *
     * @return Photo[] List of photos
     */
    public function getPhotosForGallery(Gallery $gallery): array;
}
