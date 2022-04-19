<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Login;
use app\models\Session;

class LoginController extends Controller
{

    public function login() {
        $params = [];
        return $this->render('login',$params);
    }

    public function loginpost(Request $req) {

        $login = new Login();
        $login->load($req->getBody());

        if ($login->validLogin() === 'succes') {
            $session = new Session();
            $session->login($login->username);
            $this->redirect('/');
        }

        $params = ['failMessage'=>$login->validLogin()];

        return $this->render('login',$params);

    }

    public function logout() {
        Application::$app->response->removeCookie('session_id');
        $this->redirect('/login');
    }

}