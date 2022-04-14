<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class LoginController extends Controller
{

    public function login() {
        $params = [];
        return $this->render('login',$params);
    }

    public function verifyLogin(Request $req) {

        $body = $req->getBody();

        echo $body['username'];
        echo $body['password'];

    }

}