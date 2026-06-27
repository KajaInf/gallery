<?php

namespace App\Service\Interface;

use App\Entity\Gallery;

/**
 * Provides gallery-related application operations.
 */
interface GalleryServiceInterface
{
    /**
     * Returns all galleries.
     *
     * @return Gallery[]
     */
    public function getAll(): array;

    /**
     * Saves a gallery.
     */
    public function save(Gallery $gallery): void;

    /**
     * Deletes a gallery.
     */
    public function delete(Gallery $gallery): void;
}
