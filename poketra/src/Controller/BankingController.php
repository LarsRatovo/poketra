<?php

namespace App\Controller;

use App\Entity\Banking;
use App\Repository\BankingRepository;
use App\service\ParserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
    public function create(ParserService $parser,Request $request,EntityManagerInterface $manager){
        $banking = $parser->parse($request->getContent(),Banking::class);
        $manager->persist($banking);
        $manager->flush();
        return $this->json('Ok',201);
    }
    
    #[Route('/{id}',methods:['PUT'])]
    public function update(ParserService $parser,Request $request,EntityManagerInterface $manager,Banking $banking){
        $model = $parser->parse($request->getContent(),Banking::class,$banking);
        $manager->persist($model);
        $manager->flush();
        return $this->json('Ok',200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(Banking $banking,EntityManagerInterface $manager){
        $manager->remove($banking);
        $manager->flush();
        return $this->json('Ok',200);
    }
}
