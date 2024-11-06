<?php

namespace App\Repository;

use App\Entity\Tips;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tips>
 */
class TipsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tips::class);
    }

    public function findPopularTips(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createDate', 'DESC')
            ->where('t.type = :type')
            ->setParameter('type', 'popular')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findCourseTips(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createDate', 'DESC')
            ->where('t.type = :type')
            ->setParameter('type', 'course')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Tips[] Returns an array of Tips objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tips
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
