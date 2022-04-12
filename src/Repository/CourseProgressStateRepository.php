<?php

namespace App\Repository;

use App\Entity\CourseProgressState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourseProgressState|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseProgressState|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseProgressState[]    findAll()
 * @method CourseProgressState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseProgressStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseProgressState::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CourseProgressState $entity, bool $flush = true): void
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
    public function remove(CourseProgressState $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return CourseProgressState by the id of the course and the id of the user
     */
    public function findByCourseAndUser(int $courseId, int $userId): ?CourseProgressState
    {
        return $this->findOneBy(['course' => $courseId, 'user' => $userId]);
    }

    // /**
    //  * @return CourseProgressState[] Returns an array of CourseProgressState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseProgressState
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
