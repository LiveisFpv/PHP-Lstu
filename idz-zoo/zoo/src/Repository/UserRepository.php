<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByFiltersAndSort(array $filters, string $sort, string $direction): array
    {
        $qb = $this->createQueryBuilder('u');

        if (!empty($filters['userName'])) {
            $qb->andWhere('u.userName LIKE :userName')
            ->setParameter('userName', '%' . $filters['userName'] . '%');
        }

        if (!empty($filters['userEmail'])) {
            $qb->andWhere('u.userEmail LIKE :userEmail')
            ->setParameter('userEmail', '%' . $filters['userEmail'] . '%');
        }

        $allowedFields = ['id', 'userName', 'userEmail', 'userRole'];
        if (in_array($sort, $allowedFields)) {
            $qb->orderBy("u.$sort", $direction === 'desc' ? 'DESC' : 'ASC');
        }

        return $qb->getQuery()->getResult();
    }
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
