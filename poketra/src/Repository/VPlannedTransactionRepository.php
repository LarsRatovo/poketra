<?php

namespace App\Repository;

use App\Entity\VPlannedTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VPlanedTransaction>
 *
 * @method VPlanedTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method VPlanedTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method VPlanedTransaction[]    findAll()
 * @method VPlanedTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VPlannedTransactionRepository extends ServiceEntityRepository
{
    private readonly array $filter;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VPlannedTransaction::class);
        $this->filter =  [
            'month'=>'t.transaction_month = :month',
            'day'=>'t.transaction_day = :day',
            'min_amount' =>'t.amount >= :min_amount',
            'max_amount'=>'t.amount <= :max_amount',
            'user'=>'t.user = :user ',
            'keyword'=>'t.user LIKE :keyword OR t.amount = :keyword OR type_name LIKE :keyword OR banking_name LIKE :keyword',
        ];
    }

//    /**
//     * @return VPlanedTransaction[] Returns an array of VPlanedTransaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VPlanedTransaction
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
        public function findByFilter(array $filter) : array
        {
            $builder = $this->createQueryBuilder('t');
            foreach(array_keys($filter) as $key){
                if(isset($this->filter[$key])){
                    $builder->andWhere($this->filter[$key])->setParameter($key,$filter[$key]);
                }
            }
            $builder->orderBy('t.transaction_month,t.transaction_day','ASC');
            $page = isset($filter['page']) ? $filter['page'] : 0;
            $offset = isset($filter['offset']) ? $filter['offset'] : 10;
            $builder->setFirstResult($offset*$page)->setMaxResults($offset);
            return $builder->getQuery()->getResult();
        }
}
