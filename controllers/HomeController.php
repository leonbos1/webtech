<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class HomeController extends Controller
{

    public function home() {
        $params = ['user'=>Application::$app->getUser()];
        return $this->render('home',$params);
    }

    public function handlePost(Request $req) {

        $body = $req->getBody();

        echo $body['kaas'];

    }

}