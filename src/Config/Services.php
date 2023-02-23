<?php

namespace App\Config;

use App\Http\Middlewares\Authentication;
use App\Http\Middlewares\ExceptionListener;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager as ORMEntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\ArgumentResolver\EntityValueResolver;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ContainerControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\EventListener;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $containerConfigurator) {

    $services = $containerConfigurator->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
    ;
    
    $services->load('App\\', '../{Controllers,Models,Services}/*')
        ->exclude('../{DependencyInjection,Entity,Migrations,Tests,Kernel.php}')
        ->public()
    ;

    $services->alias(ContainerInterface::class, 'service_container')
        ->public();

    $services->set(ORMSetup::class)
        ->factory([ORMSetup::class, 'createAttributeMetadataConfiguration'])
        ->arg('$paths', array(__DIR__."/../src"))
        ->arg('$isDevMode', true)
    ;

    $services->set(DriverManager::class)
        ->factory([DriverManager::class, 'getConnection'])
        ->arg('$params', [
            'driver' => $_ENV['DB_DRIVER'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'host' => $_ENV['DB_HOST'],
        ])
        ->arg('$config', service(ORMSetup::class))
    ;

    $services->set(Response::class, Response::class)
        ->public()
    ;

    $services->set(EntityManagerInterface::class, ORMEntityManager::class)
        ->arg('$eventManager', null)
        ->arg('$config', service(ORMSetup::class))
        ->arg('$conn', service(DriverManager::class))
        ->public()
    ;

    $services->set("file_locator", FileLocator::class)
        ->arg('$paths', [__DIR__])
    ;

    $services->set("route_loader", PhpFileLoader::class)
        ->arg('$locator', service("file_locator"))
    ;

    $services->set("routes", Routing\RouteCollection::class)
        ->factory([service("route_loader"), 'load'])
        ->arg('$file', __DIR__.'/../routes.php')
        ->public()
    ;

    $services->set('context', RequestContext::class);
    $services->set('matcher', UrlMatcher::class)
        ->args([service("routes"), service('context')])
    ;

    $services->set('request_stack', RequestStack::class);

    $services->set(ControllerResolverInterface::class, ContainerControllerResolver::class)
        ->arg('$container', service('service_container'))
    ;

    $services->set('request_attribute_value_resolver', ArgumentResolver\RequestAttributeValueResolver::class);

    $services->set('request_value_resolver', ArgumentResolver\RequestValueResolver::class);

    $services->set('default_value_resolver', ArgumentResolver\DefaultValueResolver::class);

    $services->set('service_value_resolver', ArgumentResolver\ServiceValueResolver::class)
        ->args([service('service_container')]);

    $services->set(ManagerRegistry::class, Registry::class)
    ->args([
        service('service_container'),
        ['default' => EntityManagerInterface::class],
        ['default' => EntityManagerInterface::class],
        'default',
        'default'
    ]);

    $services->set('entity_value_resolver', EntityValueResolver::class)
        ->args([service(ManagerRegistry::class)])
    ;

    $services->set('backed_enum_value_resolver', ArgumentResolver\BackedEnumValueResolver::class);

    $services->set('date_time_value_resolver', ArgumentResolver\DateTimeValueResolver::class);

    $services->set('variadic_value_resolver', ArgumentResolver\VariadicValueResolver::class);
     
    $services->set(ArgumentResolverInterface::class, ArgumentResolver::class)
        ->arg('$argumentValueResolvers',  [
            service('request_attribute_value_resolver'),
            service('request_value_resolver'),
            service('default_value_resolver'),
            service('service_value_resolver'),
            service('entity_value_resolver'),
            service('backed_enum_value_resolver'),
            service('date_time_value_resolver'),
            service('variadic_value_resolver'),
        ])
    ;
        
    $services->set('listener.router', EventListener\RouterListener::class)
        ->args([service('matcher'), service('request_stack')])
    ;

    $services->set('listener.response', EventListener\ResponseListener::class)
        ->args(['UTF-8'])
    ;

    $services->set("listener.auth", Authentication::class)
        ->args([])
    ;

    $services->set('listener.exception', ExceptionListener::class);

    $services->set('dispatcher', EventDispatcher::class)
        ->call('addSubscriber', [service('listener.router')])
        ->call('addSubscriber', [service('listener.response')])
        ->call('addSubscriber', [service('listener.exception')])
    ;

    $services->set(HttpKernelInterface::class, HttpKernel::class)
        ->arg('$dispatcher', service('dispatcher'))
        ->arg('$resolver', service(ControllerResolverInterface::class))
        ->arg('$requestStack', service('request_stack'))
        ->arg('$argumentResolver', service(ArgumentResolverInterface::class))
        ->public()
    ;

};