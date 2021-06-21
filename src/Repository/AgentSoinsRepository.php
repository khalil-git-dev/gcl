<?php

namespace App\Repository;

use App\Entity\AgentSoins;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgentSoins|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentSoins|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentSoins[]    findAll()
 * @method AgentSoins[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentSoinsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentSoins::class);
    }

    // /**
    //  * @return AgentSoins[] Returns an array of AgentSoins objects
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
    public function findOneBySomeField($value): ?AgentSoins
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
