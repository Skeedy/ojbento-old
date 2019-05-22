<?php

namespace App\Repository;

use App\Entity\PriceMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PriceMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceMenu[]    findAll()
 * @method PriceMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceMenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PriceMenu::class);
    }

    // /**
    //  * @return PriceMenu[] Returns an array of PriceMenu objects
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
    public function findOneBySomeField($value): ?PriceMenu
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
