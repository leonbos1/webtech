<?php

use app\controllers\WalletController;
use app\core\Application;
use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\TestController;
use app\controllers\RegisterController;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'database' => [
        'dsn' => $_ENV['DB_DOMAIN_SERVICE_NAME'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [HomeController::class,'home']);

$app->router->get('/home', [HomeController::class,'home']);

$app->router->get('/login', [LoginController::class,'index']);
$app->router->post('/login', [LoginController::class,'login']);

$app->router->get('/register', [RegisterController::class,'index']);
$app->router->post('/register', [RegisterController::class,'register']);

$app->router->get('/account', 'account');

$app->router->get('/exchange', [ExchangeController::class,'exchange']);

$app->router->get('/portfolio','portfolio');

$app->router->get('/wallet', [WalletController::class,'index']);

$app->router->get('/test', [TestController::class,'get']);

$app->router->get('/logout', [LoginController::class,'logout']);

$app->run();

?>