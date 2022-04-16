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

        $register = new User();

        $register->load($req->getBody());

        if ($register->validate() === 'succes' && $register->register()) {
            return 'Show success page';
        }

        $params = ['failMessage'=>$register->validate()];

        return $this->render('register',$params);

    }

}