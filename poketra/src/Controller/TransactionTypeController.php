<?php
namespace App\Controller;

use App\Entity\TransactionType;
use App\Repository\TransactionTypeRepository;
use App\service\ParserService;
use Doctrine\ORM\EntityManagerInterface;
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
    public function create(EntityManagerInterface $manager,Request $request,ParserService $parser){
        $type = $parser->parse($request->getContent(),TransactionType::class);
        $manager->persist($type);
        $manager->flush();
        return $this->json('Ok',201);
    }

    #[Route('/{id}',methods:['PUT'])]
    public function update(EntityManagerInterface $manager,TransactionType $transactionType,Request $request,ParserService $parser){
        $updated = $parser->parse($request->getContent(),TransactionType::class,$transactionType);
        $manager->persist($updated);
        $manager->flush();
        return $this->json('Ok',200);
    }

    #[Route('/{id}',methods:['DELETE'])]
    public function delete(EntityManagerInterface $manager,TransactionType $transactionType){
        $manager->remove($transactionType);
        $manager->flush();
        return $this->json('Ok',200);
    }
}
?>