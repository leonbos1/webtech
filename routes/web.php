<?php

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

switch ($request_uri[0]) {

    case '/':
        require './views/home.php';
        break;

    case '/wallet':
        require './views/wallet.php';
        break;

    case '/account':
        require './views/account.php';
        break;

    case '/exchange':
        require './views/exchange_table.html';
        break;

    case '/portfolio':
        require './views/portfolio.php';
        break;

    default:
        header('HTTP/1.0 404 Not Found');
        require './views/404.php';
        break;
}

?>