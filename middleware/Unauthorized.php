<?php

namespace app\middleware;

use app\core\Application;
use app\core\Controller;
use app\core\Response;
use app\core\services\AuthService;

class Unauthorized extends Middleware
{
    private array $pages;

    public function __construct($pages, protected AuthService $authService)
    {
        $this->pages = $pages;
    }

    public function handle()
    {
        if (!$this->authService->LoggedIn()) {

            if ($this->pages === []) {
                Application::$app->container->get(Response::class)->statusCode(401);
                exit();
            }
            foreach ($this->pages as $p) {
                if ($p === Application::$app->container->get(Controller::class)->getPage()) {
                    Application::$app->container->get(Response::class)->statusCode(401);
                    exit();
                }
            }
        }

    }

}