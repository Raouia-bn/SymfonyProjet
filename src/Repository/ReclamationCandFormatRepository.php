<?php

namespace App\Repository;

use App\Entity\ReclamationCandFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReclamationCandFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReclamationCandFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReclamationCandFormat[]    findAll()
 * @method ReclamationCandFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationCandFormatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReclamationCandFormat::class);
    }

    // /**
    //  * @return ReclamationCandFormat[] Returns an array of ReclamationCandFormat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReclamationCandFormat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
