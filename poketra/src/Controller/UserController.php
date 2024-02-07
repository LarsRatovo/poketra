<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('user')]
class UserController extends AbstractController
{
    #[Route('/signup',methods:['POST'])]
    public function signup(Request $request,SerializerInterface $serializer,ValidatorInterface $validator,EntityManagerInterface $entityManager): Response
    {
       $user = $serializer->deserialize($request->getContent(),User::class,'json');
       $errors = $validator->validate($user);
       if(count($errors) > 0){
            $message = "";
            foreach($errors as $error){
                $message = $message." ".$error->getMessage();
            }
            return $this->json($message,400);
       }
       $entityManager->persist($user);
       $entityManager->flush();
       return $this->json('OK',201);
    }
}
?>