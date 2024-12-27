<?php

namespace App\Repository;

use App\Entity\MotifReclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MotifReclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MotifReclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MotifReclamation[]    findAll()
 * @method MotifReclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotifReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MotifReclamation::class);
    }

    // /**
    //  * @return MotifReclamation[] Returns an array of MotifReclamation objects
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
    public function findOneBySomeField($value): ?MotifReclamation
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
