<?php

namespace app\middleware;

use app\core\Application;

class IsAdmin extends Middleware
{
    private array $pages;

    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    public function handle()
    {
        $user = Application::$app->getUser();

        if ($user->role != 'admin') {
            Application::$app->response->statusCode(401);
            exit();
        }
    }
}