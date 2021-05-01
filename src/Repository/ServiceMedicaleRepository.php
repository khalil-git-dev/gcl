<?php

namespace App\Repository;

use App\Entity\ServiceMedicale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceMedicale|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceMedicale|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceMedicale[]    findAll()
 * @method ServiceMedicale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceMedicaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceMedicale::class);
    }

    // /**
    //  * @return ServiceMedicale[] Returns an array of ServiceMedicale objects
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
    public function findOneBySomeField($value): ?ServiceMedicale
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
