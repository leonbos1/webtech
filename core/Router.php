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

    public function post($path,$callback) {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            return "Error 404 not found";
        }

        if (is_string($callback)) {
            return $this->view($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request);
    }

    public function view($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function renderViewOnly($view, $params = [])
    {
        return Application::$app->view->renderViewOnly($view, $params);
    }


}