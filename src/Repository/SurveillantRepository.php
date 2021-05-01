<?php

namespace App\Repository;

use App\Entity\Surveillant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Surveillant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Surveillant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Surveillant[]    findAll()
 * @method Surveillant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveillantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Surveillant::class);
    }

    // /**
    //  * @return Surveillant[] Returns an array of Surveillant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Surveillant
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
