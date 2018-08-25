<?php

namespace App\Repository;

use App\Entity\AssociationBddCsv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AssociationBddCsv|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssociationBddCsv|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssociationBddCsv[]    findAll()
 * @method AssociationBddCsv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssociationBddCsvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AssociationBddCsv::class);
    }

//    /**
//     * @return AssociationBddCsv[] Returns an array of AssociationBddCsv objects
//     */
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
    public function findOneBySomeField($value): ?AssociationBddCsv
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
