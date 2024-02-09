<?php

namespace App\Repository;

use App\Entity\PlannedTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlannedTransaction>
 *
 * @method PlannedTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlannedTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlannedTransaction[]    findAll()
 * @method PlannedTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlannedTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlannedTransaction::class);
    }

//    /**
//     * @return PlannedTransaction[] Returns an array of PlannedTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlannedTransaction
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
