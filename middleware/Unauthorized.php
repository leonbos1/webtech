<?php

namespace app\middleware;

use app\core\Application;

class Unauthorized extends Middleware
{
    private array $pages;

    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    public function handle()
    {
        if (!Application::$app->LoggedIn()) {

            if ($this->pages === []) {
                Application::$app->response->statusCode(401);
                exit();
            }
            foreach ($this->pages as $p) {
                if ($p === Application::$app->controller->getPage()) {
                    Application::$app->response->statusCode(401);
                    exit();
                }
            }
        }

    }

}