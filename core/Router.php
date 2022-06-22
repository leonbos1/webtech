<?php

namespace app\core;

use app\core\container\Container;

class Router
{
    protected array $routes = [];

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path,$callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = Application::$app->container->resolve(Request::class)->getPath();
        $method = Application::$app->container->resolve(Request::class)->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            Application::$app->container->resolve(Response::class)->statusCode(404);
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

        return call_user_func($callback,Application::$app->container->get(Request::class));
    }

    public function view($view, $params = [])
    {
        return Application::$app->container->get(View::class)->renderView($view, $params);
    }
}