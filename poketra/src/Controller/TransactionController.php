<?php

namespace App\Controller;

use App\Entity\Banking;
use App\Entity\Transaction;
use App\Entity\TransactionType;
use App\Repository\VTransactionRepository;
use App\services\CrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('',methods:['POST'])]
    public function create(Request $request,CrudService $service) : Response {
        $model = $service->parseObject($request->getContent(),Transaction::class);
        $banking = $service->findById($request->toArray()['banking'],Banking::class);
        $model->setBanking($banking);
        $type = $service->findById($request->toArray()['type'],TransactionType::class);
        $model->setType($type);
        $service->persistObject($model);
        return $this->json('Ok',201);
    }

    #[Route('/{id}',methods:['PUT'])]
    public function update(Request $request,CrudService $service,Transaction $transaction)
    {
        $model = $service->parseObject($request->getContent(),Transaction::class,$transaction);
        $data = $request->toArray();
        if(array_key_exists('baking',$data)){
            $banking = $service->findById($data['banking'],Banking::class);
            $model->setBanking($banking);
        }
        if(array_key_exists('type',$data)){
            $type = $service->findById($data['type'],TransactionType::class);
            $model->setType($type);
        }
        $service->persistObject($model);
        return $this->json('Ok',201);
    }

    #[Route('/{id}',methods:['GET'])]
    public function getUnique(Transaction $transaction){
        return $this->json($transaction);
    }

    #[Route('',methods:['GET'])]
    public function getWith(VTransactionRepository $repository,Request $request){
        return $this->json($repository->findByFilter(filter:$request->query->all()));
    }
}