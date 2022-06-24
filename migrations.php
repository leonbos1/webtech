<?php

use app\core\Application;
use app\core\container\Container;
use app\core\Router;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'database' => [
        'dsn' => $_ENV['DB_DOMAIN_SERVICE_NAME'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$container = new Container();
$router = new Router();

$app = new Application($container,dirname(__FILE__), $config, $router);


$app->getDatabase()->migrations();

