<?php

namespace App\Repository;

use App\Entity\Enum\SessionStatusEnum;
use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function getSessionsCurrentlyTrade()  {
        return $this->createQueryBuilder('s')
            ->select('s')
            ->andWhere('s.status <> :status')
            ->setParameter('status', SessionStatusEnum::Sold)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getPairCurrentlyTrading() {
        return array_column($this->createQueryBuilder('s')
            ->select('s.pair')
            ->andWhere('s.status <> :status')
            ->setParameter('status', SessionStatusEnum::Sold)
            ->groupBy('s.pair')
            ->getQuery()
            ->getResult(),
            'pair'
        );
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
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
    public function findOneBySomeField($value): ?Session
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
