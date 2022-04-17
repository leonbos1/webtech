<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\User;
use app\models\Wallet;

class WalletController extends Controller
{

    public function index() {

        $username = Application::$app->getUser();
        $user = User::findOne(['username' => $username]);
        $wallet = Wallet::getWalletByUser($user);

        $params = [
            'user'=>$username,
            'wallet'=>$wallet,
            ];

        return $this->render('wallet',$params);
    }


}