<?php

/**
 * Photo repository.
 */

namespace App\Repository;

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

    //    /**
    //     * @return Photo[] Returns an array of Photo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Photo
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

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
