<?php

namespace app\middleware;

use app\core\Application;

class AuthorizationMiddleware extends Middleware
{
    private array $pages;

    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    public function exec()
    {
        if (!Application::$app->LoggedIn()) {

            if ($this->pages === []) {
                Application::$app->controller->redirect('/login');
            }
            foreach ($this->pages as $p) {
                if ($p === Application::$app->controller->getPage()) {
                    Application::$app->controller->redirect('/login');
                }
            }
        }
    }

}