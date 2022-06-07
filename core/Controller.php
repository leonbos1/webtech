<?php

namespace app\core;

use app\middleware\Middleware;

class Controller
{
    public string $layout = 'main';
    private array $middlewares = [];
    private string $page;

    public function render($view, $params) {
        return Application::$container->get(View::class)->view($view, $params);

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

    public function setPage($page) {
        $this->page=$page;
    }

    public function getPage()
    {
        return $this->page;
    }

}