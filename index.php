<?php 

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

$container = require_once 'src/Bootstrap/app.php';

$request = Request::createFromGlobals();

$kernel = $container->get(HttpKernelInterface::class);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
