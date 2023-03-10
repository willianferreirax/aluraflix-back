<?php

use App\Config\Environment;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader as ContainerPhpFileLoader;
use Symfony\Component\Config\FileLocator;

Environment::loadEnv(__DIR__ . '/../../.env');

$containerBuilder = new ContainerBuilder();
$loader = new ContainerPhpFileLoader($containerBuilder, new FileLocator(__DIR__));
$loader->load(__DIR__. '/../Config/Services.php');
$containerBuilder->compile();

return $containerBuilder;
