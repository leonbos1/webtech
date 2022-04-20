<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\User;
use app\models\Wallet;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new Unauthorized(['wallet']));
    }

    public function wallet() {

        $user = Application::$app->getUser();
        $wallet = Wallet::getWalletByUser($user);

        $params = [
            'user'=>$user,
            'wallet'=>$wallet,
            ];

        return $this->render('wallet', $params);
    }

    public function addeuros() {

        $user = Application::$app->getUser();
        $wallet = Wallet::getWalletByUser($user);

        $amount = Application::$app->request->getBody()['add_euro'];

        if ($amount >= 0) {
            $wallet->addEuros($amount);
        }

        Application::$app->controller->redirect('/wallet');
    }


}