<?php

use App\Controllers\AuthenticationController;
use App\Controllers\CategoryController;
use App\Controllers\UserController;
use App\Controllers\VideoController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    $routes->add('get_videos', '/videos')
        ->controller([VideoController::class, 'index'])
        ->methods(['GET'])
    ;

    $routes->add("free_videos", "/videos/free")
        ->controller([VideoController::class,  'freeVideos'])
        ->methods(["GET"])
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

    $routes->add('info', '/info')
        ->controller([VideoController::class, 'info'])
        ->methods(['GET']) 
    ;

    $routes->add('get_categories', '/categories')
        ->controller([CategoryController::class, 'index'])
        ->methods(['GET'])
    ;

    $routes->add('get_category', '/categories/{id}')
        ->controller([CategoryController::class, 'show'])
        ->methods(['GET'])
    ;

    $routes->add('post_category', '/categories')
        ->controller([CategoryController::class, 'store'])
        ->methods(['POST'])
    ;

    $routes->add('put_category', '/categories/{id}')
        ->controller([CategoryController::class, 'update'])
        ->methods(['PUT'])
    ;

    $routes->add('delete_category', '/categories/{id}')
        ->controller([CategoryController::class, 'destroy'])
        ->methods(['DELETE'])
    ;

    $routes->add("get_videos_by_category", "/categories/{id}/videos")
        ->controller([CategoryController::class, "getVideosByCategory"])
        ->methods(["GET"])
    ;

    $routes->add("post_user", "/users")
        ->controller([UserController::class, "store"])
        ->methods(["POST"])
    ;

    $routes->add("post_authenticate", "/authenticate")
        ->controller([AuthenticationController::class, "authenticate"])
        ->methods(["POST"])
    ;

};