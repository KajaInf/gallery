<?php

/**
 * Photo repository.
 */

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PhotoRepository.
 *
 * @extends ServiceEntityRepository<Photo>
 */
class PhotoRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Doctrine registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    /**
     * Saves photo.
     *
     * @param Photo $photo Photo entity
     */
    public function save(Photo $photo): void
    {
        $this->getEntityManager()->persist($photo);
        $this->getEntityManager()->flush();
    }

    /**
     * Deletes photo with related comments.
     *
     * @param Photo $photo Photo entity
     */
    public function delete(Photo $photo): void
    {
        foreach ($photo->getTags() as $tag) {
            $photo->removeTag($tag);
        }

        $comments = $this->getEntityManager()
            ->getRepository(Comment::class)
            ->findBy(['photo' => $photo]);

        foreach ($comments as $comment) {
            $this->getEntityManager()->remove($comment);
        }

        $this->getEntityManager()->remove($photo);
        $this->getEntityManager()->flush();
    }

    /**
     * Finds photos assigned to a tag.
     *
     * @param int $tagId Tag identifier
     *
     * @return Photo[] List of photos
     */
    public function findByTagId(int $tagId): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.tags', 'selectedTag')
            ->leftJoin('p.gallery', 'g')
            ->addSelect('g')
            ->leftJoin('p.tags', 't')
            ->addSelect('t')
            ->andWhere('selectedTag.id = :tagId')
            ->setParameter('tagId', $tagId)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Finds photos with relations.
     *
     * @return Photo[] List of photos
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.gallery', 'g')
            ->addSelect('g')
            ->leftJoin('p.tags', 't')
            ->addSelect('t')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
