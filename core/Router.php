<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            //insert 404 view here
            return "Error 404 not found";
        }

        if (is_string($callback)) {
            return $this->view($callback);
        }

        return call_user_func($callback);
    }

    public function view($view) {
        include_once __DIR__."/../views/$view.php";
    }

}