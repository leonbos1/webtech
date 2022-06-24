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

        $reqMethod = $request->getMethod();

        $route = $request->getPath();
        $action = $this->routes[$reqMethod][$route];

        if (!$action) {
            throw new \Exception();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);
            $page = $action[1];
            $class->setPage($page);
            Application::$app->controller = $class;
            $middlewares = $class->getMiddleware();

            foreach ($middlewares as $m) {
                $m->handle();
            }
            $action[0] = $class;


            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], [$this->container->get('app\core\Request')]);
            }
        }

        throw new \Exception('route not found');
    }

    public function view($view, $params = [])
    {
        return $this->container->get(View::class)->renderView($view, $params);
    }
}