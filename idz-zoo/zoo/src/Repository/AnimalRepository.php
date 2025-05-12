<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Animal>
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function findByFiltersAndSort(array $filters, string $sort, string $direction)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->leftJoin('a.care', 'c')
            ->addSelect('c'); 

        if (!empty($filters['animalName'])) {
            $queryBuilder->andWhere('c.animalName LIKE :animalName')
                ->setParameter('animalName', '%' . $filters['animalName'] . '%');
        }

        if (!empty($filters['animalGender'])) {
            $queryBuilder->andWhere('a.animalGender = :animalGender')
                ->setParameter('animalGender', $filters['animalGender']);
        }

        if (!empty($filters['animalAge'])) {
            $queryBuilder->andWhere('a.animalAge = :animalAge')
                ->setParameter('animalAge', $filters['animalAge']);
        }

        $allowedFields = ['animalName', 'animalGender', 'animalAge', 'animalCage'];
        if (in_array($sort, $allowedFields)) {
            if ($sort === 'animalName'){
                $queryBuilder->orderBy("c.$sort", $direction === 'desc' ? 'DESC' : 'ASC');
            }
            else{
                $queryBuilder->orderBy("a.$sort", $direction === 'desc' ? 'DESC' : 'ASC');
            }
        }

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Animal[] Returns an array of Animal objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Animal
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
