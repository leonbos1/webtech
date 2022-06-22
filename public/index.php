<?php

use app\controllers\AdminController;
use app\controllers\PortfolioController;
use app\controllers\ProfileController;
use app\controllers\WalletController;
use app\core\Application;
use app\controllers\HomeController;
use app\controllers\LoginController;
use app\controllers\RegisterController;
use app\controllers\ExchangeController;
use app\core\container\Container;
use app\core\Router;
use app\models\Crypto;

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

$container = new Container();

$router = $container->get(Router::class);

$app = new Application($container,dirname(__DIR__), $config, $router);

$router->get('/', [HomeController::class,'home']);
$router->get('/home', [HomeController::class,'home']);

$router->get('/login', [LoginController::class,'login']);
$router->post('/login', [LoginController::class,'loginpost']);

$router->get('/register', [RegisterController::class,'register']);
$router->post('/register', [RegisterController::class,'registerpost']);

$router->get('/portfolio',[PortfolioController::class,'portfolio']);
$router->post('/portfolio',[PortfolioController::class,'trade']);

$router->get('/wallet', [WalletController::class,'wallet']);
$router->post('/wallet', [WalletController::class, 'addeuros']);

$router->get('/logout', [LoginController::class,'logout']);

$router->get('/profile', [ProfileController::class,'profile']);

$router->get('/admin', [AdminController::class,'admin']);
$router->post('/admin', [AdminController::class,'addCrypto']);

$router->get('/exchange', [ExchangeController::class,'exchange']);
$router->post('/exchange', [ExchangeController::class,'exchange_select']);

$crypto_shorts = Crypto::getAllCryptoShorts();

foreach ($crypto_shorts as $crypto) {
    $router->get("/exchange/$crypto", [ExchangeController::class, 'crypto']);
}



$app->run();

?>