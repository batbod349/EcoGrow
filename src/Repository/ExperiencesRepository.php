<?php

namespace App\Repository;

use App\Entity\Experiences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Experiences>
 */
class ExperiencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Experiences::class);
    }

    public function getTotalPoints(int $userId): int
    {
        return (int) $this->createQueryBuilder('e')
            ->select('SUM(e.quantity)')
            ->where('e.user = :userId')
            ->andWhere('e.type = :type')
            ->setParameter('userId', $userId)
            ->setParameter('type', 1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findAvailablePoints(int $userId): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function getCompletedDailyQuests(int $userId, \DateTime $date): array
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.quest', 'q')
            ->where('e.user = :userId')
            ->andWhere('q.type = :dailyType')
            ->andWhere('e.completedAt BETWEEN :startOfDay AND :endOfDay')
            ->setParameter('userId', $userId)
            ->setParameter('dailyType', 'Daily')
            ->setParameter('startOfDay', $date->setTime(0, 0, 0))
            ->setParameter('endOfDay', $date->setTime(23, 59, 59))
            ->getQuery()
            ->getResult();
    }

    public function findPointsLast7Days(int $userId): array
    {
        $today = new \DateTime();
        $lastWeek = (clone $today)->modify('-7 days');

        return $this->createQueryBuilder('e')
            ->select('SUM(e.quantity) as totalPoints, e.date as day')
            ->where('e.user = :userId')
            ->andWhere('e.date BETWEEN :lastWeek AND :today')
            ->setParameter('userId', $userId)
            ->setParameter('lastWeek', $lastWeek)
            ->setParameter('today', $today)
            ->groupBy('day')
            ->getQuery()
            ->getResult();
    }

    // Dans le repository ExperiencesRepository
    public function findByDate(int $userId, \DateTime $date): array
    {
        // Utiliser DQL pour rechercher les expériences en fonction de la date seule (sans l'heure)
        $startOfDay = $date->setTime(0, 0, 0); // Début de la journée
        $endOfDay = clone $startOfDay;
        $endOfDay->setTime(23, 59, 59); // Fin de la journée

        return $this->createQueryBuilder('e')
            ->where('e.user = :userId')
            ->andWhere('e.date BETWEEN :startOfDay AND :endOfDay')
            ->setParameter('userId', $userId)
            ->setParameter('startOfDay', $startOfDay)
            ->setParameter('endOfDay', $endOfDay)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Experiences[] Returns an array of Experiences objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Experiences
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
