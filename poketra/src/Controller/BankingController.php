<?php

namespace App\Controller;

use App\Entity\Banking;
use App\Repository\BankingRepository;
use App\services\CrudService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/banking')]
class BankingController extends AbstractController
{
    #[Route('',methods:['GET'])]
    public function get(Request $request,BankingRepository $repository): JsonResponse
    {
        $user = $request->query->get('user');
        if($user){
            return $this->json($repository->findByUser($user));
        }
        return $this->json($repository->findAll());
    }

    #[Route('',methods:['POST'])]
    public function create(CrudService $service,Request $request){
        $service->persist($request->getContent(),Banking::class);
        return $this->json('Ok',201);
    }
    
    #[Route('/{id}',methods:['PUT'])]
    public function update(Request $request,Banking $banking,CrudService $service){
        $service->update($banking,$request->getContent(),Banking::class);
        return $this->json('Ok',200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(Banking $banking,CrudService $service){
        $service->remove($banking);
        return $this->json('Ok',200);
    }
}
