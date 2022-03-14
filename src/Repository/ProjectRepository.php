<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Project $entity, bool $flush = true): void
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
    public function remove(Project $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

        /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getAllOrdered()
    {
        return $this->createQueryBuilder('p')
        ->OrderBy('p.createdAt','DESC')
        ->getQuery()
        ->getResult();
    }



            /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getNbWorker(int $id)
    {
        $result = $this->createQueryBuilder('p')
        ->join('p.worktimes', 'w')
        ->select('COUNT(DISTINCT w.employe)')
        ->where('p.id = :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getSingleScalarResult();
        return $result;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getNbRentable()
    {

        //marche po
        $result = $this->createQueryBuilder('p')
        ->join('p.worktimes', 'w')
        ->join('e.worktimes','w')
        ->from('employe','e')
        ->groupBy('e.id')
        ->orderBy('SUM(w.time*e.cost)', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

       /* return $this->createQueryBuilder('p')
        ->OrderBy('p.createdAt','DESC')
        ->getQuery()
        ->getResult();*/

        return $result;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAllQuery()
    {
        $total = $this->createQueryBuilder('e')
        ->getQuery();

        return $total;
    }
    

    // /**
    //  * @return Project[] Returns an array of Project objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Project
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
