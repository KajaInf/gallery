<?php

/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Service\Interface\TagServiceInterface;

/**
 * Class TagService.
 */
class TagService implements TagServiceInterface
{
    /**
     * Constructor.
     *
     * @param TagRepository $tagRepository Tag repository
     */
    public function __construct(private readonly TagRepository $tagRepository)
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
     */
    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    /**
     * Deletes a tag.
     *
     * @param Tag $tag Tag entity
     */
    public function delete(Tag $tag): void
    {
        $this->tagRepository->delete($tag);
    }
}
