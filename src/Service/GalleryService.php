<?php

/**
 * Gallery service.
 */

namespace App\Service;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;
use App\Service\Interface\GalleryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GalleryService.
 */
class GalleryService implements GalleryServiceInterface
{
    /**
     * Constructor.
     *
     * @param GalleryRepository      $galleryRepository Gallery repository
     * @param EntityManagerInterface $entityManager     Entity manager
     */
    public function __construct(private readonly GalleryRepository $galleryRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * Returns all galleries.
     *
     * @return Gallery[] List of galleries
     */
    public function getAll(): array
    {
        return $this->galleryRepository->findAll();
    }

    /**
     * Saves a gallery.
     *
     * @param Gallery $gallery Gallery entity
     */
    public function save(Gallery $gallery): void
    {
        $this->entityManager->persist($gallery);
        $this->entityManager->flush();
    }

    /**
     * Checks if gallery can be deleted.
     *
     * @param Gallery $gallery Gallery entity
     *
     * @return bool True if gallery can be deleted
     */
    public function canDelete(Gallery $gallery): bool
    {
        return 0 === $this->galleryRepository->countPhotos($gallery);
    }
    /**
     * Deletes a gallery.
     *
     * @param Gallery $gallery Gallery entity
     */
    public function delete(Gallery $gallery): void
    {
        $this->entityManager->remove($gallery);
        $this->entityManager->flush();
    }
}
