<?php

namespace App\Repository;

use App\Entity\VTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VTransaction>
 *
 * @method VTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method VTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method VTransaction[]    findAll()
 * @method VTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VTransactionRepository extends ServiceEntityRepository
{
    private readonly array $filter;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VTransaction::class);
        $this->filter =  [
            'min_date'=>'t.transaction_date >= :min_date',
            'max_date'=>'t.transaction_date <= :max_date',
            'min_amount' =>'t.amount >= :min_amount',
            'max_amount'=>'t.amount <= :max_amount',
            'user'=>'t.user = :user ',
            'keyword'=>'t.user LIKE :keyword OR t.amount = :keyword OR type_name LIKE :keyword OR banking_name LIKE :keyword',
        ];
    }

//    /**
//     * @return VTransaction[] Returns an array of VTransaction objects
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

//    public function findOneBySomeField($value): ?VTransaction
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
        $builder->orderBy('t.transaction_date','DESC');
        $page = isset($filter['page']) ? $filter['page'] : 0;
        $offset = isset($filter['offset']) ? $filter['offset'] : 50;
        $builder->setFirstResult($offset*$page)->setMaxResults($offset);
        return $builder->getQuery()->getResult();
    }
    public function findByUserAndLimit(int $id) : array
    {
        return $this->createQueryBuilder('t')
                ->andWhere('t.user = :user')
                ->setParameter('user',$id)
                ->orderBy('t.transaction_date','DESC')
                ->setMaxResults(20)
                ->getQuery()
                ->getResult();
    }
}
