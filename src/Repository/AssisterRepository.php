<?php

namespace App\Repository;

use App\Entity\Assister;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assister|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assister|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assister[]    findAll()
 * @method Assister[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssisterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assister::class);
    }

    // /**
    //  * @return Assister[] Returns an array of Assister objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Assister
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
