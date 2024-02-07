<?php
namespace App\Controller;

use App\Entity\User;
use App\service\ParserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/signup',methods:['POST'])]
    public function signup(Request $request,ParserService $parser,EntityManagerInterface $entityManager,UserPasswordHasherInterface $hasher): Response
    {
        try {
            $user = $parser->parse($request->getContent(),User::class);
        } catch (\Throwable $th) {
            return new Response($th->getMessage(),400,['content-type'=>'application/json; charset=utf-8']);
        }
       $user->setPassword($hasher->hashPassword($user, "password"));
       $entityManager->persist($user);
       $entityManager->flush();
       return $this->json('OK',201);
    }
}
?>