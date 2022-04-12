<?php

namespace App\Repository;

use App\Entity\SectionProgressState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SectionProgressState|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionProgressState|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionProgressState[]    findAll()
 * @method SectionProgressState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionProgressStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionProgressState::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(SectionProgressState $entity, bool $flush = true): void
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
    public function remove(SectionProgressState $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return SectionProgressState Returns an array of SectionProgressState objects
     * Search by the id of the section and the id of the user
     */
    public function findBySectionAndUser(int $sectionId, int $userId): ?SectionProgressState
    {
        return $this->findOneBy(['section' => $sectionId, 'user' => $userId]);
    }

    // /**
    //  * @return SectionProgressState[] Returns an array of SectionProgressState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SectionProgressState
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
