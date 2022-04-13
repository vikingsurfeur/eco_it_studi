<?php

namespace App\Repository;

use App\Entity\UserProgressState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProgressState|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProgressState|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProgressState[]    findAll()
 * @method UserProgressState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProgressStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProgressState::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserProgressState $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(UserProgressState $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    /**
     * @return UserProgressState
     * Search by the id of the course and the id of the user
     */
    public function findByUserAndCourse(int $userId, int $courseId): ?UserProgressState
    {
        return $this->findOneBy(['user' => $userId, 'course' => $courseId]);
    }

    // /**
    //  * @return UserProgressState[] Returns an array of UserProgressState objects
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
    public function findOneBySomeField($value): ?UserProgressState
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
