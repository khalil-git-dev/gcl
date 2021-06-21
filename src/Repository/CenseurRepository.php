<?php

namespace App\Repository;

use App\Entity\Censeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Censeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Censeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Censeur[]    findAll()
 * @method Censeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CenseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Censeur::class);
    }

    // /**
    //  * @return Censeur[] Returns an array of Censeur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Censeur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
