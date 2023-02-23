<?php

namespace App\Http\Middlewares;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $response = new JsonResponse([
                'status' => false,	
                'message' => 'Not found',
            ], 404);
            $event->setResponse($response);
            return;
        }

        $exception = $event->getThrowable();
        $response = new JsonResponse();
        $response->setData([
            'status' => false,
            'message' => $exception->getMessage(),
        ]);
        $response->setStatusCode($exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
