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
            ->select('q.id') // Sélectionne explicitement l'ID de la quête
            ->innerJoin('e.quest', 'q')
            ->where('e.user = :userId')
            ->andWhere('q.type = :dailyType')
            ->andWhere('e.completedAt BETWEEN :startOfDay AND :endOfDay')
            ->setParameter('userId', $userId)
            ->setParameter('dailyType', 'Daily')
            ->setParameter('startOfDay', $date->setTime(0, 0, 0))
            ->setParameter('endOfDay', (clone $date)->setTime(23, 59, 59))
            ->getQuery()
            ->getArrayResult();
    }

    public function getCompletedMonthlyQuests(int $userId, \DateTime $date): array
    {
        // Définir le début du mois (1er jour à minuit)
        $startOfMonth = $date->setDate($date->format('Y'), $date->format('m'), 1)->setTime(0, 0, 0);

        // Définir la fin du mois (dernier jour à 23h59)
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        return $this->createQueryBuilder('e')
            ->select('q.id') // Sélectionne explicitement l'ID de la quête
            ->innerJoin('e.quest', 'q')
            ->where('e.user = :userId')
            ->andWhere('q.type = :monthlyType')
            ->andWhere('e.completedAt BETWEEN :startOfMonth AND :endOfMonth')
            ->setParameter('userId', $userId)
            ->setParameter('monthlyType', 'Monthly')
            ->setParameter('startOfMonth', $startOfMonth)
            ->setParameter('endOfMonth', $endOfMonth)
            ->getQuery()
            ->getArrayResult();
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

    public function getTotalDailyQuestsCompleted(int $userId): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.user = :user')
            ->andWhere('e.source = :source')
            ->setParameter('user', $userId)
            ->setParameter('source', 'Daily')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getTotalMonthlyQuestsCompleted(int $userId): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.user = :user')
            ->andWhere('e.source = :source')
            ->setParameter('user', $userId)
            ->setParameter('source', 'Monthly')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAverageDailyQuestsPerWeek(int $userId): float
    {
        $totalDailyQuests = $this->getTotalDailyQuestsCompleted($userId);
        $weeksInMonth = (new \DateTime())->format('W') - (new \DateTime('first day of this month'))->format('W') + 1;
        return $totalDailyQuests / $weeksInMonth;
    }

    public function getAverageMonthlyQuestsPerMonth(int $userId): float
    {
        $totalMonthlyQuests = $this->getTotalMonthlyQuestsCompleted($userId);
        $monthsInYear = 12;
        return $totalMonthlyQuests / $monthsInYear;
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
