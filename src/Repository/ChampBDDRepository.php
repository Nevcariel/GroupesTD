<?php

namespace App\Repository;

use App\Entity\ChampBDD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChampBDD|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChampBDD|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChampBDD[]    findAll()
 * @method ChampBDD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChampBDDRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChampBDD::class);
    }

//    /**
//     * @return ChampBDD[] Returns an array of ChampBDD objects
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
    public function findOneBySomeField($value): ?ChampBDD
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
