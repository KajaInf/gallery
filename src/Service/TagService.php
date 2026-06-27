<?php

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\Interface\TagServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Handles tag persistence operations.
 */
class TagService implements TagServiceInterface
{
    /**
     * Creates the tag service.
     */
    public function __construct(
        private readonly TagRepository $tagRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    /**
     * Returns all tags.
     *
     * @return Tag[]
     */
    public function getAll(): array
    {
        return $this->tagRepository->findAll();
    }

    /**
     * Saves a tag.
     */
    public function save(Tag $tag): void
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    }

    /**
     * Deletes a tag.
     */
    public function delete(Tag $tag): void
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}
