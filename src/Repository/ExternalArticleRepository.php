<?php

namespace App\Repository;

use App\Entity\ExternalArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ExternalArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExternalArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExternalArticle[]    findAll()
 * @method ExternalArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExternalArticle::class);
    }

    // /**
    //  * @return ExternalArticle[] Returns an array of ExternalArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ExternalArticle
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
