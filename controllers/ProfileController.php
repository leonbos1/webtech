<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\middleware\RedirectIfUnauthorized;
use app\models\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->addMiddleware(new RedirectIfUnauthorized(['profile']));
    }

    public function profile() {
        $user = Application::$app->getUser();
        $username = $user->username;
        $created_at = $user->created_at;

        $params = [
            'user'=>$username,
            'created_at'=>$created_at,
        ];

        return $this->render('profile',$params);
    }
}