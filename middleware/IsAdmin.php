<?php

namespace app\middleware;

use app\core\Application;
use app\core\Response;

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
            Application::$app->container->get(Response::class)->statusCode(401);
            exit();
        }
    }
}