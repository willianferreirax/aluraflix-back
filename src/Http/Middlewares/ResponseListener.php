<?php

namespace App\Http\Middlewares;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListener implements EventSubscriberInterface{

    public function onKernelResponse(ResponseEvent $event)
    {

        $response = $event->getResponse();
        $data = json_decode($response->getContent(), true);

        if (in_array($response->getStatusCode(), [200, 201, 202, 203, 204, 205, 206, 207, 208, 226])) {
            $json['status'] = "true";
            $json['data'] = $data;
        }

        $response->setContent(json_encode($json ?? $data));

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

}