<?php
namespace App\Controller;

use App\Entity\TransactionType;
use App\Repository\TransactionTypeRepository;
use App\services\CrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('transaction_type')]
class TransactionTypeController extends AbstractController
{
    #[Route('',methods:['GET'])]
    public function get(Request $request,TransactionTypeRepository $repository): Response
    {
        $user = $request->query->get('user');
        if($user){
            return $this->json($repository->findByUser($user));
        }
        return $this->json($repository->findAll());
    }

    #[Route('',methods:['POST'])]
    public function create(CrudService $service,Request $request){
        $service->persist($request->getContent(),TransactionType::class);
        return $this->json('Ok',201);
    }

    #[Route('/{id}',methods:['PUT'])]
    public function update(CrudService $service,TransactionType $transactionType,Request $request){
        $service->update($transactionType,$request->getContent(),TransactionType::class);
        return $this->json('Ok',200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(CrudService $service,TransactionType $transactionType){
        $service->remove($transactionType);
        return $this->json('Ok',200);
    }
}
?>