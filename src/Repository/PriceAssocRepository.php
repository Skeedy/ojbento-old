<?php

namespace App\Repository;

use App\Entity\PriceAssoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PriceAssoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceAssoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceAssoc[]    findAll()
 * @method PriceAssoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceAssocRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PriceAssoc::class);
    }

    // /**
    //  * @return PriceAssoc[] Returns an array of PriceAssoc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriceAssoc
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
