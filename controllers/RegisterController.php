<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\models\User;
use app\models\Wallet;

class RegisterController extends Controller
{

    public function register() {
        $params = [];
        Template::view('register.html', $params);
    }

    public function registerpost(Request $req) {

        $register = new User();

        $register->load($req->getBody());

        if ($register->validate() === 'succes' && $register->register()) {
            $wallet = new Wallet();
            $toLoad = ['user_id'=>$register->getIdByUsername($register->username),"euro"=>0, "BTC"=>0, "ETH"=>0, "LTC"=>0, "XRP"=>0, "DOGE"=>0];
            $wallet->load($toLoad);
            $wallet->save();

            Application::$app->controller->redirect('/login');
        }

        $params = ['failMessage'=>$register->validate()];

        Template::view('register.html', $params);

    }

}