<?php

namespace App\Repository;

use App\Entity\Employe;
use App\Entity\Project;
use App\Entity\Worktime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Worktime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worktime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worktime[]    findAll()
 * @method Worktime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorktimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worktime::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Worktime $entity, bool $flush = true): void
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
    public function remove(Worktime $entity, bool $flush = true): void
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
    public function getTimeAll()
    {
        $result = $this->createQueryBuilder('w')
        ->select('SUM(w.time)')
        ->getQuery()
        ->getSingleScalarResult();

        return $result;
    }

    public function getFiveLast(){
        $result = $this->createQueryBuilder('w')->orderBy('w.createdAt', 'DESC')->setMaxResults(4)->getQuery()->getResult();
        return $result;
    }

    public function getAllProjectsWithPrice(){
        $result = $this->createQueryBuilder('w')
        ->select('p.id, p.nom, p.createdAt, p.cost, p.DeliveredAt, SUM(w.time) as time, SUM(w.time * e.cost) as total')
        ->innerJoin('w.projet', 'p')
        ->innerJoin('w.employe', 'e')
        ->groupBy('p.id')
        ->orderBy('p.id', 'DESC')
        ->getQuery()
        ->getResult();
        return $result;
    }

    public function getByIdQuery(int $id){
        $result = $this->createQueryBuilder('w')
        ->orderBy('w.createdAt', 'DESC')
        ->where('w.id = :id')
        ->setParameter('id',$id)
        ->getQuery();

        return $result;
    }

               /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getWorktimesQuery(Employe $id)
    {
        $result = $this->createQueryBuilder('w')
        ->where('w.employe = :id')
        ->setParameter('id',$id)
        ->getQuery();

        return $result;
    }

                  /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getWorktimesRpojectQuery(Project $id)
    {
        $result = $this->createQueryBuilder('w')
        ->where('w.projet = :id')
        ->setParameter('id',$id)
        ->getQuery();

        return $result;
    }


    // /**
    //  * @return Worktime[] Returns an array of Worktime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Worktime
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
