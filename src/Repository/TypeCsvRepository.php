<?php

namespace App\Repository;

use App\Entity\TypeCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeCsv|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCsv|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCsv[]    findAll()
 * @method TypeCsv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCsvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeCsv::class);
    }

//    /**
//     * @return TypeCsv[] Returns an array of TypeCsv objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeCsv
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
