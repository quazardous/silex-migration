# Quazardous Silex Doctrine Migrations Provider
Yet another one but for Silex 2 !

## Intstallation

Add quazardous/silex-migration to your composer.json and register the service.

```php
$app->register(new Quazardous\Silex\Provider\ConsoleServiceProvider, [
    'db.migrations.path' => '/path/to/migrations',
]);

```

You can customize the provider with parameters :
- db.migrations.namespace
- db.migrations.path
- db.migrations.table_name
- db.migrations.name

See tests/console.php for a full working minimum example.

## Demo

```bash
cd demo
touch demo.db
../vendor/bin/doctrine orm:generate-entities entity/
../vendor/bin/doctrine orm:generate-proxies
php ./console.php migrations:diff
php ./console.php migrations:migrate

```



