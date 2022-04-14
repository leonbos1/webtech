<?php

require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;

$app = new Application();

$app->router->get('/', 'home');

$app->router->get('/home', 'home');

$app->router->get('/account', 'account');

$app->router->get('/exchange', 'exchange');

$app->router->get('/portfolio','portfolio');

$app->router->get('/wallet', 'wallet');

$app->run();

?>