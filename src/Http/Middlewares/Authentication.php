<?php

namespace App\Http\Middlewares;

use App\Http\Contracts\FreeToRequest;
use App\Http\Contracts\MustAuthenticate;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class Authentication implements EventSubscriberInterface{

    public function __construct(
        private \App\Services\TokenParser $tokenParser
    ){}

    public function onKernelController(ControllerEvent $event)
    {

        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (array_key_exists(MustAuthenticate::class, $event->getAttributes()) && 
            !array_key_exists(FreeToRequest::class, $event->getAttributes())
        ) {

            $token = $event->getRequest()->headers->get('authorization');

            if (empty($token)) {
                throw new AccessDeniedHttpException('This action needs a valid token!', null, 401);
            }

            $token = str_replace('Bearer ', '', $token);

            $token = $this->tokenParser->parse($token);

            $event->getRequest()->attributes->set('token', $token);
            
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }


}