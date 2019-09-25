<?php

namespace App\Repository;

use App\Entity\SessionLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SessionLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionLog[]    findAll()
 * @method SessionLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionLog::class);
    }

    // /**
    //  * @return SessionLog[] Returns an array of SessionLog objects
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
    public function findOneBySomeField($value): ?SessionLog
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
