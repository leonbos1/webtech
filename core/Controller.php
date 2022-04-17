<?php

namespace app\core;

class Controller
{

    public string $layout = 'home';

    public function render($view, $params = []) {
        $params = ['user'=>Application::$app->getUser()];
        return Application::$app->router->view($view, $params);

    }

    public function redirect($url)
    {
        header("Location: $url");
    }

}