<?php

namespace App\Repository;

use App\Entity\LessonProgressState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LessonProgressState|null find($id, $lockMode = null, $lockVersion = null)
 * @method LessonProgressState|null findOneBy(array $criteria, array $orderBy = null)
 * @method LessonProgressState[]    findAll()
 * @method LessonProgressState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonProgressStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LessonProgressState::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(LessonProgressState $entity, bool $flush = true): void
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
    public function remove(LessonProgressState $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return LessonProgressState
     * Search by the id of the lesson and the id of the user
     */
    public function findByLessonAndUser(int $lessonId, int $userId): ?LessonProgressState
    {
        return $this->findOneBy(['lesson' => $lessonId, 'user' => $userId]);
    }

    // /**
    //  * @return LessonProgressState[] Returns an array of LessonProgressState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LessonProgressState
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
