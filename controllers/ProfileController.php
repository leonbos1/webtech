<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\middleware\AuthorizationMiddleware;
use app\models\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->addMiddleware(new AuthorizationMiddleware(['profile']));
    }

    public function profile() {
        $user = Application::$app->getUser();
        $created_at = User::findOne(['username' => $user])->created_at;

        $params = [
            'user'=>$user,
            'created_at'=>$created_at,
        ];

        return $this->render('profile',$params);
    }
}