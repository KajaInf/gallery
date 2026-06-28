<?php

/**
 * Gallery entity.
 */

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Gallery.
 */
#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    /**
     * Gets identifier.
     *
     * @return int|null Identifier
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets title.
     *
     * @return string|null Gallery title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets title.
     *
     * @param string $title Gallery title
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
