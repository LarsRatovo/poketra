<?php

namespace App\EventSubscriber;

use App\util\NotSuitableException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use JsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListenerSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if($exception instanceof UniqueConstraintViolationException){
            $problem = explode('entry',$exception->getMessage());
            $event->setResponse(new Response(str_replace('\'','',explode('for',$problem[1])[0]).' existe déjà',400,['conten-type'=>'application/json; charset=UTF-8;']));
        }else if($exception instanceof NotSuitableException){
            $event->setResponse(new JsonResponse(['message'=>$exception->getMessage()],400));
        }else if($exception instanceof NotFoundHttpException){
            $event->setResponse(new JsonResponse(['message'=>'Ressource introuvable'],404));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
