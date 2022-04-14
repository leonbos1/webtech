<?php

namespace app\core;

class Controller
{

    public string $layout = 'home';

    public function render($view, $params = []) {

        return Application::$app->router->view($view, $params);

    }

}