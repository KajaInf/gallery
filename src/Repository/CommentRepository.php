<?php

/**
 * Comment repository.
 */

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CommentRepository.
 *
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Doctrine registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * Finds comments assigned to photo.
     *
     * @param Photo $photo  Photo entity
     * @param int   $limit  Results limit
     * @param int   $offset Results offset
     *
     * @return Comment[] List of comments
     */
    public function findByPhoto(Photo $photo, int $limit, int $offset): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.photo = :photo')
            ->setParameter('photo', $photo)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    /**
     * Counts comments assigned to photo.
     *
     * @param Photo $photo Photo entity
     *
     * @return int Number of comments
     */
    public function countByPhoto(Photo $photo): int
    {
        return (int) $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->andWhere('c.photo = :photo')
            ->setParameter('photo', $photo)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    /**
    //     * @return Comment[] Returns an array of Comment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
