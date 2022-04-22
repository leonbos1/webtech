<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\CryptoWallet;
use app\models\Exchange;
use app\models\Wallet;

class PortfolioController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new Unauthorized(['portfolio']));
    }

    protected array $cryptos = [
        'euro' => 'Euro',
        'btc' => 'Bitcoin',
        'xrp' => 'Ripple',
        'ltc' => 'Litecoin',
        'doge' => 'Dogecoin',
        'eth' =>'Ethereum'
    ];

    public function portfolio() {
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
            'cryptos'=>$this->cryptos,
            'currencies'=>$currencies,
            'amount'=>$amounts,
        ];

        Template::view('layouts/portfolio.html', $params);
    }

    public function trade(Request $request) {
        $firstCurrency = $request->getBody()['firstcurrency'];
        $secondCurrency = $request->getBody()['secondcurrency'];
        $amount = $request->getBody()['amount'];

        var_dump( Exchange::getCurrentPrice($firstCurrency) );

        $params = [];

        Template::view('layouts/portfolio.hmtl', $params);
    }

}