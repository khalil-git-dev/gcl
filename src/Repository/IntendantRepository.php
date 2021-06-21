<?php

namespace App\Repository;

use App\Entity\Intendant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Intendant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intendant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intendant[]    findAll()
 * @method Intendant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntendantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intendant::class);
    }

    // /**
    //  * @return Intendant[] Returns an array of Intendant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Intendant
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
