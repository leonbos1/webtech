<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\models\CryptoWallet;
use app\models\User;
use app\models\Wallet;

class RegisterController extends Controller
{

    public function __construct(protected Controller $controller)
    {}

    public function register() {
        $params = [];
        Template::view('register.html', $params);
    }

    public function registerpost(Request $req) {

        $register = new User();

        $register->load($req->getBody());

        if ($register->validate() === 'succes' && $register->register()) {
            $user_id = User::getIdByUsername($register->username);
            $wallet = new Wallet();
            $wallet->load(['user_id'=>$user_id]);
            $wallet->save();
            $wallet_id = Wallet::findOne(["user_id"=>$user_id])->id;

            $crypto_wallet = new CryptoWallet();

            $crypto_wallet->load(['wallet_id'=>$wallet_id,'crypto_short'=>'eu','amount'=>0]);
            $crypto_wallet->save();

            $this->controller->redirect('/login');
        }

        $params = ['failMessage'=>$register->validate()];

        Template::view('register.html', $params);

    }

}