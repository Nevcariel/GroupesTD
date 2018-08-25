<?php

namespace App\Repository;

use App\Entity\ChampCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChampCsv|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChampCsv|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChampCsv[]    findAll()
 * @method ChampCsv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampCsvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChampCsv::class);
    }

//    /**
//     * @return ChampCsv[] Returns an array of ChampCsv objects
//     */
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
    public function findOneBySomeField($value): ?ChampCsv
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
