<?php

namespace App\Service;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;
use App\Service\Interface\GalleryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Handles gallery persistence operations.
 */
class GalleryService implements GalleryServiceInterface
{
    /**
     * Creates the gallery service.
     */
    public function __construct(
        private readonly GalleryRepository $galleryRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Returns all galleries.
     *
     * @return Gallery[]
     */
    public function getAll(): array
    {
        return $this->galleryRepository->findAll();
    }

    /**
     * Saves a gallery.
     */
    public function save(Gallery $gallery): void
    {
        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
    }

    /**
     * Deletes a gallery.
     */
    public function delete(Gallery $gallery): void
    {
        $this->entityManager->remove($gallery);
        $this->entityManager->flush();
    }
}
