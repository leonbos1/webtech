<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\core\Template;
use app\models\Crypto;
use app\models\Exchange;

class ExchangeController extends Controller
{
    protected array $cryptos = [
        'btc' => 'Bitcoin',
        'xrp' => 'Ripple',
        'ltc' => 'Litecoin',
        'doge' => 'Dogecoin',
        'eth' =>'Ethereum'
    ];

    public function exchange() {
        $params = [
            'cryptos_short'=> Crypto::getAllCryptoShorts(),
            'cryptos' => Crypto::getAllCryptoNames()
        ];

        Template::view('layouts/exchange.html', $params);
    }

    public function exchange_select(Request $request)
    {
        $crypto = $request->getBody()['crypto'];

        Application::$app->controller->redirect("/exchange/$crypto");
    }

    public function crypto(Request $request) {
        $crypto_type = str_replace("/exchange/","",$request->getPath());

        $params = [
            'prices' => Exchange::getCoinPrices($this->cryptos[$crypto_type],30, 'daily'),
            'crypto_type' => $this->cryptos[$crypto_type],
            'cryptos_short'=> Crypto::getAllCryptoShorts(),
            'cryptos' => Crypto::getAllCryptoNames()
        ];

        Template::view('layouts/exchange.html', $params);
    }
}