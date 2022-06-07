<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\Template;
use app\models\Login;
use app\models\Session;

class LoginController extends Controller
{

    public function login() {
        $params = [];
        Template::view('login.html', $params);
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

        Template::view('login.html', $params);

    }

    public function logout() {
        Application::$app->container->resolve(Response::class)->removeCookie('session_id');
        $this->redirect('/login');
    }

}