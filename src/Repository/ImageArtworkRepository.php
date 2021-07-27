<?php

namespace App\Repository;

use App\Entity\ImageArtwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageArtwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageArtwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageArtwork[]    findAll()
 * @method ImageArtwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageArtwork::class);
    }

    // /**
    //  * @return ImageArtwork[] Returns an array of ImageArtwork objects
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
    public function findOneBySomeField($value): ?ImageArtwork
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
