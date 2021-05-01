<?php

namespace App\Repository;

use App\Entity\Maintenancier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maintenancier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maintenancier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maintenancier[]    findAll()
 * @method Maintenancier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaintenancierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maintenancier::class);
    }

    // /**
    //  * @return Maintenancier[] Returns an array of Maintenancier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Maintenancier
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
