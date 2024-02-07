<?php

namespace App\Controller;

use App\Repository\BankingRepository;
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
    
}
