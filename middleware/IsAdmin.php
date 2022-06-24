<?php

namespace app\middleware;

use app\core\Application;
use app\core\Response;

class IsAdmin extends Middleware
{

    public function __construct(protected array $pages, $authService)
    {
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