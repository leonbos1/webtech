<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\services\AuthService;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\Crypto;
use app\models\CryptoWallet;
use app\models\Exchange;
use app\models\User;
use app\models\Wallet;

class PortfolioController extends Controller
{
    public function __construct(protected Controller $controller,
                                protected AuthService $authService,
                                protected Request $request,
                                protected Response $response)
    {
        $this->addMiddleware(new Unauthorized(['portfolio'], $this->authService, $this->controller, $this->response));

    }

    public function portfolio() {
        $user = $this->authService->getUser();
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