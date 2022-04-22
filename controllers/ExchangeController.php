<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\core\Template;
use app\middleware\Unauthorized;
use app\models\Crypto;
use app\models\Exchange;

class ExchangeController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new Unauthorized(['exchange']));
    }

    public function exchange() {
        $params = [
            'cryptos'=>Crypto::getAllCryptoNames(),
            'cryptoshorts'=>Crypto::getAllCryptoShorts()
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
        $prices = Exchange::getCoinPrices($this->cryptos[$crypto_type],30, 'daily');

        for ($i=0; $i < count($prices); $i++) {
            $date_int = 30 - $prices[$i][0];
            $prices[$i][0] = date("Y-m-d", strtotime("-$date_int day", time()));
        }

        $params = [
            'prices' => $prices,
            'crypto_type' => $this->cryptos[$crypto_type],
            'cryptos'=>Crypto::getAllCryptoNames(),
            'cryptoshorts'=>Crypto::getAllCryptoShorts()
        ];

        Template::view('layouts/exchange.html', $params);
    }
}