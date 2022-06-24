<?php

namespace app\core;

use app\core\container\Container;

class Router
{
    private Container $container;

    public function __construct()
    {
    }

    public function setContainer(Container $container) {
        $this->container = $container;
    }

    protected array $routes = [];

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path,$callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $request = $this->container->get('app\core\Request');
        $response = $this->container->get('app\core\Response');


        $path = $request->getPath();
        $method = $request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $response->statusCode(404);
            exit();
        }

        $page = $callback[1];
        $controller = new $callback[0];
        $controller->setPage($page);

        Application::$app->controller = $controller;

        $middlewares = $controller->getMiddleware();

        foreach ($middlewares as $m) {
            $m->handle();
        }
        $callback[0] = $controller;

        return call_user_func($callback,$request);
    }

    public function view($view, $params = [])
    {
        return $this->container->get(View::class)->renderView($view, $params);
    }
}