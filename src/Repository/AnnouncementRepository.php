<?php

namespace App\Repository;

use App\Entity\Announcement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }
    public function getRespondedAnnouncements($user)
    {
        return $this->createQueryBuilder('a')
            ->where('r.respondant=:user')
            ->getQuery()
            ->getResult();
    }

    public function findByTitleOrDiscipline(array $keywords)
    {
        $qb = $this->createQueryBuilder('a');
        foreach ($keywords as $key => $keyword) {
            $qb
                ->where('d.name LIKE :keyword' . $key)
                ->orWhere('a.title LIKE :keyword' . $key)
                ->andWhere('a.date >= CURRENT_DATE() or a.date is NULL')
                ->setParameter('keyword' . $key, '%' . $keyword . '%')
                ->leftJoin('a.discipline', 'd');
        }
           $qb
            ->orderBy('a.createdAt', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function getAnnouncementsByDate()
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a')
            ->where('a.date >= CURRENT_DATE()')
            ->orWhere('a.date is NULL')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();
        return $qb->getResult();
    }
    // /**
    //  * @return Announcement[] Returns an array of Announcement objects
    //  */
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
    public function findOneBySomeField($value): ?Announcement
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
