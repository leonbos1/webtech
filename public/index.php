<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\controllers\HomeController;
use app\controllers\LoginController;


$app = new Application(dirname(__DIR__));

$app->router->get('/', [HomeController::class,'home']);

$app->router->get('/home', [HomeController::class,'home']);

$app->router->get('/login', [LoginController::class,'login']);

$app->router->get('/account', 'account');

$app->router->get('/exchange', 'exchange');

$app->router->get('/portfolio','portfolio');

$app->router->get('/wallet', 'wallet');

$app->run();

?>