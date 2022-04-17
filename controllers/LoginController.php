<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Login;
use app\models\User;

class LoginController extends Controller
{

    public function index() {
        $params = [];
        return $this->render('login',$params);
    }

    public function login(Request $req) {

        $login = new Login();
        $login->load($req->getBody());

        if ($login->validLogin() === 'succes') {
            Application::$app->setUser($login->username);
            $this->redirect('/');
        }

        $params = ['failMessage'=>$login->validLogin()];

        return $this->render('login',$params);

    }

    public function logout() {
        Application::$app->setUser('guest');
        $this->redirect('/login');
    }

}