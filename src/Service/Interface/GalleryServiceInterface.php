<?php

/**
 * Gallery service interface.
 */

namespace App\Service\Interface;

use App\Entity\Gallery;

/**
 * Interface GalleryServiceInterface.
 */
interface GalleryServiceInterface
{
    /**
     * Returns all galleries.
     *
     * @return Gallery[] List of galleries
     */
    public function getAll(): array;

    /**
     * Saves a gallery.
     *
     * @param Gallery $gallery Gallery entity
     */
    public function save(Gallery $gallery): void;

    /**
     * Deletes a gallery.
     *
     * @param Gallery $gallery Gallery entity
     */
    public function delete(Gallery $gallery): void;
        /**
     * Checks if gallery can be deleted.
     *
     * @param Gallery $gallery Gallery entity
     *
     * @return bool True if gallery can be deleted
     */
    public function canDelete(Gallery $gallery): bool;
}
