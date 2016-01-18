<?php

namespace Quazardous\Silex\Provider;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Quazardous\Silex\Console\ConsoleEvents;
use Quazardous\Silex\Console\ConsoleEvent;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Silex\Api\BootableProviderInterface;
use Silex\Application;

class MigrationsServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Container $app)
    {
        $defaults = [
            'db.migrations.namespace' => 'DoctrineMigrations',
            'db.migrations.path' => null,
            'db.migrations.table_name' => null,
            'db.migrations.name' => null,
        ];

        foreach ($defaults as $key => $value) {
            if (!isset($app[$key])) {
                $app[$key] = $value;
            }
        }

    }
    
    public function boot(Application $app) {
        $app['dispatcher']->addListener(ConsoleEvents::INIT, function (ConsoleEvent $event) use ($app) {
            $console = $event->getConsole();
        
            $helpers = ['dialog' => new QuestionHelper()];
        
            if (isset($app['orm.em'])) {
                $helpers['em'] = new EntityManagerHelper($app['orm.em']);
            }
        
            $helperSet = new HelperSet($helpers);
        
            $console->setHelperSet($helperSet);
        
            $config = new Configuration($app['db']);
            $config->setMigrationsNamespace($app['db.migrations.namespace']);
        
            if ($app['db.migrations.path']) {
                $config->setMigrationsDirectory($app['db.migrations.path']);
                $config->registerMigrationsFromDirectory($app['db.migrations.path']);
            }
        
            if ($app['db.migrations.name']) {
                $config->setName($app['db.migrations.name']);
            }
        
            if ($app['db.migrations.table_name']) {
                $config->setMigrationsTableName($app['db.migrations.table_name']);
            }
        
            $commands = [
                new Command\DiffCommand(),
                new Command\ExecuteCommand(),
                new Command\GenerateCommand(),
                new Command\MigrateCommand(),
                new Command\StatusCommand(),
                new Command\VersionCommand(),
            ];
        
            foreach ($commands as $command) {
                /** @var \Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand $command */
                $command->setMigrationConfiguration($config);
                $console->add($command);
            }
        });
        
    }
}
