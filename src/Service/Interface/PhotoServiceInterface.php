<?php

namespace App\Service\Interface;

use App\Entity\Photo;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Gallery;

/**
 * Provides photo-related application operations.
 */
interface PhotoServiceInterface
{
    /**
     * Returns photos filtered by tag or all photos sorted by creation date.
     *
     * @return Photo[]
     */
    public function getPhotos(?string $tagId): array;

    /**
     * Returns selected tag by id.
     */
    public function getSelectedTag(?string $tagId): ?Tag;

    /**
     * Saves a photo.
     */
    public function save(Photo $photo): void;

    /**
     * Stores uploaded image file and assigns filename to photo.
     */
    public function uploadImage(Photo $photo, UploadedFile $imageFile): void;

    /**
     * Deletes a photo with related data and file.
     */
    public function delete(Photo $photo): void;

    /**
     * Returns comments assigned to a photo.
     */
    public function getComments(Photo $photo): array;

    /**
    * Returns photos assigned to a gallery.
    *
    * @return Photo[]
    */
    public function getPhotosForGallery(Gallery $gallery): array;
}
