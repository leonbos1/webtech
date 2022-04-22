<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
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

        $user = Application::$app->getUser();
        $wallet = Wallet::getWalletByUser($user);
        $cryptowallets = CryptoWallet::getCryptoWalletsByUser($user);

        $crypto_wallet_id = 0;

        foreach ($cryptowallets as $cryptowallet) {
            if($cryptowallet['crypto_short'] == 'eu') {
                $crypto_wallet_id = $cryptowallet['crypto_wallet_id'];
            }
        }

        $cryptowallet = CryptoWallet::findOne(['crypto_wallet_id'=>$crypto_wallet_id]);

        if (!$cryptowallet) {
            $cryptowallet = new CryptoWallet();
            $cryptowallet->load(['wallet_id'=>$wallet->id,'crypto_short'=>'eu','amount'=>0]);
            $cryptowallet->save();
        }

        $amount = Application::$app->request->getBody()['add_euro'];

        $cryptowallet->addEuro($amount);

        Application::$app->controller->redirect('/wallet');
    }
}