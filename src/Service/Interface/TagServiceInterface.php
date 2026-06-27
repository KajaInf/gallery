<?php

namespace App\Service\Interface;

use App\Entity\Tag;

/**
 * Provides tag-related application operations.
 */
interface TagServiceInterface
{
    /**
     * Returns all tags.
     *
     * @return Tag[]
     */
    public function getAll(): array;

    /**
     * Saves a tag.
     */
    public function save(Tag $tag): void;

    /**
     * Deletes a tag.
     */
    public function delete(Tag $tag): void;
}
