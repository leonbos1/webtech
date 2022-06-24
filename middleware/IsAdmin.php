<?php

namespace app\middleware;

use app\core\Application;
use app\core\Response;
use app\core\services\AuthService;

class IsAdmin extends Middleware
{

    public function __construct(protected array $pages,protected AuthService $authService)
    {
    }

    public function handle()
    {
        $user = $this->authService->getUser();

        if ($user->role != 'admin') {
            Application::$app->container->get(Response::class)->statusCode(401);
            exit();
        }
    }
}