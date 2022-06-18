<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\Crypto;
use app\models\CryptoWallet;
use app\models\Exchange;
use app\models\User;
use app\models\Wallet;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new Unauthorized(['portfolio']));
    }

    public function portfolio() {
        $user = Application::$app->getUser();
        $wallet = Wallet::getWalletByUser($user);

        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);
        $amounts = array();
        $owned_cryptos = array();

        foreach ($cryptowallets as $cryptowallet) {
            $currencies[] = $cryptowallet['crypto_short'];
            $amounts[] = $cryptowallet['amount'];
            if ($cryptowallet['amount'] > 0) {
                $owned_cryptos[] = $cryptowallet['crypto_short'];
            }
        }

        $params = [
            'user'=>$user,
            'all_crypto'=> Crypto::getAllCryptoNames(),
            'all_crypto_short'=> Crypto::getAllCryptoShorts(),
            'currencies'=>$currencies,
            'amount'=>$amounts,
            'owned_cryptos'=>$owned_cryptos
        ];

        Template::view('layouts/portfolio.html', $params);
    }

    public function trade(Request $request) {
        $firstCurrency = $request->getBody()['firstcurrency'];
        $secondCurrency = $request->getBody()['secondcurrency'];
        $amount = $request->getBody()['amount'];

        echo $firstCurrency;
        echo $secondCurrency;
        echo $amount;
        echo $secondCurrency;

        CryptoWallet::exchangeCurrency($firstCurrency, $amount, $secondCurrency);
        /*
        $statement = Application::$app->database->connection->prepare("update crypto_wallet
                                                                     set amount = $new_amount
                                                                     where wallet_id = $wallet_id and crypto_short = '$short'");
        $statement->execute();
        */

        $this->redirect('/portfolio');
    }

    public static function getCurrency($user_id, $currency)
    {
        $user = User::findOne(['id'=>$user_id]);
        $wallet = Wallet::getWalletByUser($user);
        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);

        foreach ($cryptowallets as $cryptowallet) {
            if ($cryptowallet['crypto_short'] == $currency) {
                return $cryptowallet['amount'];
            }
        }
    }

}