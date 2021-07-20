<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }
        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByFirstnameAndLastname(array $keywords)
    {
        $qb = $this->createQueryBuilder('u');
        foreach ($keywords as $key => $keyword) {
            $qb
                ->orWhere('u.firstname LIKE :keyword' . $key)
                ->orWhere('u.lastname LIKE :keyword' . $key)
                ->orWhere('u.pseudo LIKE :keyword' . $key)
                ->setParameter('keyword' . $key, '%' . $keyword . '%');
        }
        $qb
            ->andHaving('u.isActive = true')
            ->andHaving('u.roles LIKE :role')
            ->setParameter('role', '["ROLE_USER"]')
            ->orderBy('u.updatedAt', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function findByExpertise(array $keywords)
    {
        $qb = $this->createQueryBuilder('u');
        foreach ($keywords as $key => $keyword) {
            $qb
                ->orWhere('u.expertise LIKE :keyword' . $key)
                ->setParameter('keyword' . $key, '%' . $keyword . '%');
        }
            $qb
                ->andHaving('u.isActive = true')
                ->andHaving('u.roles LIKE :role')
                ->setParameter('role', '["ROLE_USER"]')
                ->orderBy('u.updatedAt', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function findByCitiesNameAndZipcode(array $keywords)
    {
        $qb = $this->createQueryBuilder('u');
        foreach ($keywords as $key => $keyword) {
            $qb
                ->orWhere('c.name LIKE :keyword' . $key)
                ->orWhere('c.zipCode LIKE :keyword' . $key)
                ->setParameter('keyword' . $key, '%' . $keyword . '%');
        }
        $qb
            ->andHaving('u.isActive = true')
            ->andHaving('u.roles LIKE :role')
            ->setParameter('role', '["ROLE_USER"]')
            ->leftJoin('u.city', 'c')
            ->orderBy('u.updatedAt', 'DESC');
        return $qb->getQuery()->getResult();
    }

    public function findAll($order = 'ASC')
    {
        $qb = $this->createQueryBuilder('u')
            ->andHaving('u.roles LIKE :role')
            ->andHaving('u.isActive = true')
            ->setParameter('role', '["ROLE_USER"]')
            ->orderBy('u.createdAt', $order);
        return $qb->getQuery()->getResult();
    }

    public function findByRoleUser($order = 'ASC')
    {
        $qb = $this->createQueryBuilder('u')
            ->orWhere('u.roles LIKE :role')
            ->andWhere('u.isActive = true')
            ->setParameter('role', '["ROLE_USER"]')
            ->orderBy('u.createdAt', $order);
        return $qb->getQuery()->getResult();
    }

    public function findWithPosition()
    {
        $qb = $this->createQueryBuilder('u')
            ->andWhere('u.podium IS NOT NULL')
            ->orderBy('u.podium', 'ASC');
        return  $qb->getQuery()->getResult();
    }

    public function findByAdmin()
    {
        $qb = $this->createQueryBuilder('u')
            ->orWhere('u.roles LIKE :role')
            ->andWhere('u.isActive = true')
            ->setParameter('role', '["ROLE_ADMIN"]');
        return  $qb->getQuery()->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
