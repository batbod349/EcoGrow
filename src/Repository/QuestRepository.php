<?php

namespace App\Repository;

use App\Entity\Quest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quest>
 */
class QuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quest::class);
    }

    public function findDailyQuests(\DateTime $date): array
    {
        return $this->createQueryBuilder('q')
            ->where('q.date = :date')
            ->andWhere('q.type = :type')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('type', 'daily')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findMonthlyChallenges(\DateTime $date): array
    {
        $startOfMonth = $date->modify('first day of this month')->setTime(0, 0);
        $endOfMonth = $date->modify('last day of this month')->setTime(23, 59, 59);

        return $this->createQueryBuilder('q')
            ->where('q.date BETWEEN :start AND :end')
            ->andWhere('q.type = :type')
            ->setParameter('start', $startOfMonth->format('Y-m-d H:i:s'))
            ->setParameter('end', $endOfMonth->format('Y-m-d H:i:s'))
            ->setParameter('type', 'monthly')
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Quest[] Returns an array of Quest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Quest
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
