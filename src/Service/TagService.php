<?php

/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\Interface\TagServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TagService.
 */
class TagService implements TagServiceInterface
{
    /**
     * Constructor.
     *
     * @param TagRepository          $tagRepository Tag repository
     * @param EntityManagerInterface $entityManager Entity manager
     */
    public function __construct(private readonly TagRepository $tagRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * Returns all tags.
     *
     * @return Tag[] List of tags
     */
    public function getAll(): array
    {
        return $this->tagRepository->findAll();
    }

    /**
     * Saves a tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return void
     */
    public function save(Tag $tag): void
    {
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    }

    /**
     * Deletes a tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return void
     */
    public function delete(Tag $tag): void
    {
        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}
