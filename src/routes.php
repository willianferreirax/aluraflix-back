<?php

use App\Controllers\VideoController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('get_videos', '/videos')
        ->controller([VideoController::class, 'index'])
        ->methods(['GET'])
    ;

    $routes->add('get_video', '/videos/{id}')
        ->controller([VideoController::class, 'show'])
        ->methods(['GET'])
    ;

    $routes->add('post_video', '/videos')
        ->controller([VideoController::class, 'store'])
        ->methods(['POST'])
    ;

    $routes->add('put_video', '/videos/{id}')
        ->controller([VideoController::class, 'update'])
        ->methods(['PUT'])
    ;

    $routes->add('delete_video', '/videos/{id}')
        ->controller([VideoController::class, 'destroy'])
        ->methods(['DELETE']) 
    ;

};