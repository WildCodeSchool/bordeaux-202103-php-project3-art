<?php

namespace App\Repository;

use App\Entity\ImageHappening;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageHappening|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageHappening|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageHappening[]    findAll()
 * @method ImageHappening[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageHappeningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageHappening::class);
    }

    // /**
    //  * @return ImageHappening[] Returns an array of ImageHappening objects
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
    public function findOneBySomeField($value): ?ImageHappening
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
