<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\middleware\RedirectIfUnauthorized;
use app\models\User;
use app\models\Wallet;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new RedirectIfUnauthorized(['wallet']));
    }

    public function wallet() {

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