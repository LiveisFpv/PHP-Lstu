<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ticket>
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }
    public function findByFiltersAndSort(array $filters, string $sort, string $direction): array
    {
        $qb = $this->createQueryBuilder('t');

        if (!empty($filters['ticketDate'])) {
            $qb->andWhere('t.ticketDate = :ticketDate')
                ->setParameter('ticketDate', $filters['ticketDate']);
        }

        if (!empty($filters['ticketTime'])) {
            $qb->andWhere('t.ticketTime LIKE :ticketTime')
                ->setParameter('ticketTime', '%' . $filters['ticketTime'] . '%');
        }

        if (!empty($filters['ticketCost'])) {
            $qb->andWhere('t.ticketCost LIKE :ticketCost')
                ->setParameter('ticketCost', '%' . $filters['ticketCost'] . '%');
        }

        if (!empty($filters['userEmail'])) {
            $qb->andWhere('t.userEmail LIKE :userEmail')
                ->setParameter('userEmail', '%' . $filters['userEmail'] . '%');
        }

        $allowedFields = ['id', 'ticketDate', 'ticketTime', 'ticketCost', 'userEmail'];
        if (in_array($sort, $allowedFields)) {
            $qb->orderBy("t.$sort", $direction === 'desc' ? 'DESC' : 'ASC');
        }

        return $qb->getQuery()->getResult();
    }
//    /**
//     * @return Ticket[] Returns an array of Ticket objects
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

//    public function findOneBySomeField($value): ?Ticket
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
