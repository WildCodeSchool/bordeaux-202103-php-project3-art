<?php

namespace App\Repository;

use App\Entity\Happening;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Happening|null find($id, $lockMode = null, $lockVersion = null)
 * @method Happening|null findOneBy(array $criteria, array $orderBy = null)
 * @method Happening[]    findAll()
 * @method Happening[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HappeningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Happening::class);
    }

    public function findByName(array $keywords)
    {
        $qb = $this->createQueryBuilder('h');
        foreach ($keywords as $key => $keyword) {
            $qb
                ->orwhere('h.title LIKE :keyword' . $key)
                ->setParameter('keyword' . $key, '%' . $keyword . '%');
        }
            $qb
            ->orderBy('h.dateStart', 'ASC');
        return $qb->getQuery()->getResult();
    }
     /**
      * @return Happening[] Returns an array of Happening objects
      */


    /*
    public function findOneBySomeField($value): ?Happening
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
