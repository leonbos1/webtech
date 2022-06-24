<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\services\AuthService;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\User;

class ProfileController extends Controller
{

    public function __construct(protected Controller $controller,
                                protected AuthService $authService,
                                protected Request $request,
                                protected Response $response)
    {
        $this->addMiddleware(new Unauthorized(['profile'], $this->authService, $this->controller, $this->response));

    }

    public function profile() {
        $user = $this->authService->getUser();
        $username = $user->username;
        $created_at = $user->created_at;

        $params = [
            'user'=>$username,
            'created_at'=>$created_at,
            'userdata', $this->getUserData()
        ];

        Template::view('profile.html', $params);
    }
}