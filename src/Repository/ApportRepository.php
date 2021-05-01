<?php

namespace App\Repository;

use App\Entity\Apport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apport[]    findAll()
 * @method Apport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apport::class);
    }

    // /**
    //  * @return Apport[] Returns an array of Apport objects
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
    public function findOneBySomeField($value): ?Apport
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
