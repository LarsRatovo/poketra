<?php

namespace App\Repository;

use App\Entity\Banking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Banking>
 *
 * @method Banking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banking[]    findAll()
 * @method Banking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banking::class);
    }

//    /**
//     * @return Banking[] Returns an array of Banking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Banking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findByUser($user) : array
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.user = :user')
        ->setParameter('user',$user)
        ->getQuery()
        ->getResult();
    }
}
