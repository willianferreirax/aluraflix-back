<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . '/src/Models'],
    true
);

// replace with mechanism to retrieve EntityManager in your app
$entityManager = EntityManager::create(
    [
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '',
        'dbname' => 'testsymfony',
    ],
    $config
);

return ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);