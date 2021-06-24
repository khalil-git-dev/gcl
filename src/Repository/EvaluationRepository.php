<?php

namespace App\Repository;

use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Evaluation[]    findDevoirSemestreByDiscipline(String $typeEval, String $semestre, Discipline::class $discipline) 
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    /**
     * @return Evaluation[] Returns an array of Evaluation objects
     */
    public function findEvaluationSemestreByDiscipline($semestre,  $discipline)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.semestre = :val2')
            ->andWhere('e.discipline = :val3')
            ->setParameter('val2', $semestre)
            ->setParameter('val3', $discipline)
            ->orderBy('e.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Evaluation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
