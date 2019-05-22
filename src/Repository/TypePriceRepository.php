<?php

namespace App\Repository;

use App\Entity\TypePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypePrice[]    findAll()
 * @method TypePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypePriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypePrice::class);
    }

    // /**
    //  * @return TypePrice[] Returns an array of TypePrice objects
    //  */
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
    public function findOneBySomeField($value): ?TypePrice
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
