<?php

/**
 * Tag service interface.
 */

namespace App\Service\Interface;

use App\Entity\Tag;

/**
 * Interface TagServiceInterface.
 */
interface TagServiceInterface
{
    /**
     * Returns all tags.
     *
     * @return Tag[] List of tags
     */
    public function getAll(): array;

    /**
     * Saves a tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return void
     */
    public function save(Tag $tag): void;

    /**
     * Deletes a tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return void
     */
    public function delete(Tag $tag): void;
}
