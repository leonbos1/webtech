<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

class RegisterController extends Controller
{

    public function index() {
        $params = [];
        return $this->render('register',$params);
    }

    public function register(Request $req) {

        $registerModel = new User();

        $registerModel->load($req->getBody());

        if ($registerModel->validate() && $registerModel->save()) {
            return 'Show success page';
        }


        return $this->render('register');

    }

}