<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\CryptoWallet;
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

        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);
        $currencies = array();
        $amounts = array();

        foreach ($cryptowallets as $cryptowallet) {
            $currencies[] = $cryptowallet['crypto_short'];
            $amounts[] = $cryptowallet['amount'];
        }

        $params = [
            'user'=>$user,
            'currencies'=>$currencies,
            'amount'=>$amounts,
            ];

        Template::view('layouts/wallet.html', $params);
    }

    public function addEuros() {

        $amount = Application::$app->container->get(Request::class)->getBody()['add_euro'];

        CryptoWallet::addEuro($amount);

        Application::$app->container->get(Controller::class)->redirect('/wallet');
    }
}