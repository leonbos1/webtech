<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\services\AuthService;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\User;

class ProfileController extends Controller
{

    public function __construct(protected AuthService $authService)
    {
        $this->addMiddleware(new Unauthorized(['profile'], $this->authService));
    }

    public function profile() {
        $user = Application::$app->getUser();
        $username = $user->username;
        $created_at = $user->created_at;

        $params = [
            'user'=>$username,
            'created_at'=>$created_at,
        ];

        Template::view('profile.html', $params);
    }
}