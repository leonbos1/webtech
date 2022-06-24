<?php

namespace app\core;

use app\core\services\AuthService;
use app\middleware\Middleware;
use stdClass;

class Controller
{
    public string $layout = 'main';
    private array $middlewares = [];
    private string $page;

    public function __construct(protected AuthService $authService)
    {
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function addMiddleware(Middleware $middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddleware() {
        return $this->middlewares;
    }

    public function getUserData() {
        $data = new stdClass();
        $data->loggedin = $this->authService->LoggedIn();
        $data->user = $this->authService->getUser();
        $data->admin = $this->authService->isAdmin();

        return $data;
    }

    public function setPage($page) {
        $this->page=$page;
    }

    public function getPage()
    {
        return $this->page;
    }

}