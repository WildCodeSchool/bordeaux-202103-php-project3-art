<?php

namespace App\Repository;

use App\Entity\ImageExternalArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageExternalArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageExternalArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageExternalArticle[]    findAll()
 * @method ImageExternalArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageExternalArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageExternalArticle::class);
    }

    // /**
    //  * @return ImageExternalArticle[] Returns an array of ImageExternalArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageExternalArticle
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
