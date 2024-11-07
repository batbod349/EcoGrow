<?php

namespace App\Repository;

use App\Entity\Friends;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Friends>
 */
class FriendsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Friends::class);
    }


    public function getFriends(int $userId): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.user1', 'u1')
            ->innerJoin('f.user2', 'u2')
            ->where('u1.id = :userId OR u2.id = :userId')
            ->andWhere('f.accepted = true')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function isFriendshipExists($user1Id, $user2Id): bool
    {
        $qb = $this->createQueryBuilder('f');
        $qb->where('f.user1 = :user1 AND f.user2 = :user2')
            ->orWhere('f.user1 = :user2 AND f.user2 = :user1')
            ->andWhere('f.accepted = true')
            ->setParameter('user1', $user1Id)
            ->setParameter('user2', $user2Id);

        return (bool) $qb->getQuery()->getOneOrNullResult();
    }

    public function isFriendshipRequest(int $user1Id, int $user2Id): ?Friends
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.user1 = :user1 AND f.user2 = :user2')
            ->orWhere('f.user1 = :user2 AND f.user2 = :user1')
            ->setParameter('user1', $user1Id)
            ->setParameter('user2', $user2Id)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }

    public function acceptFriendship(int $user1Id, int $user2Id): void
    {
        $qb = $this->createQueryBuilder('f')
            ->update()
            ->set('f.accepted', ':accepted')
            ->where('f.user1 = :user2 AND f.user2 = :user1')
            ->setParameter('accepted', true)
            ->setParameter('user1', $user1Id)
            ->setParameter('user2', $user2Id)
            ->getQuery();
        $qb->execute();
    }

//    /**
//     * @return Friends[] Returns an array of Friends objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Friends
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
