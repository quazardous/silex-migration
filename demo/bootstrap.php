<?php
include __DIR__.'/../vendor/autoload.php';

use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Quazardous\Silex\Provider\MigrationsServiceProvider;
use Quazardous\Silex\Provider\ConsoleServiceProvider;


$app = new Silex\Application;

$app->register(new DoctrineServiceProvider, [
    'db.options' => [
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/demo.db',
    ],
]);

$app->register(new DoctrineOrmServiceProvider, [
    'orm.proxies_dir' => __DIR__ . '/cache/orm/proxies',
    'orm.em.options' => [
        'cache_namespace' => 'ies_orm_',
        'mappings' => [
            // Using actual filesystem paths
            [
                'type' => 'annotation',
                'namespace' => 'Demo',
                'path' => __DIR__.'/entity/',
                'use_simple_annotation_reader' => true,
            ],
        ],
    ],
]);

return $app;
