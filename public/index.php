<?php

use app\controllers\PortfolioController;
use app\controllers\ProfileController;
use app\controllers\WalletController;
use app\core\Application;
use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\TestController;
use app\controllers\RegisterController;
use app\controllers\ExchangeController;

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

$app->router->get('/login', [LoginController::class,'login']);
$app->router->post('/login', [LoginController::class,'loginpost']);

$app->router->get('/register', [RegisterController::class,'register']);
$app->router->post('/register', [RegisterController::class,'registerpost']);

$app->router->get('/exchange', [ExchangeController::class,'exchange']);

$app->router->get('/portfolio',[PortfolioController::class,'portfolio']);

$app->router->get('/wallet', [WalletController::class,'wallet']);

$app->router->get('/logout', [LoginController::class,'logout']);

$app->router->get('/profile', [ProfileController::class,'profile']);

$app->run();

?>