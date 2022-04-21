<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\core\Template;

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
        $params = ['cryptos'=>$this->cryptos];
        Template::view('exchange_select.html', $params);
    }

    public function exchange_select(Request $request)
    {
        $crypto = $request->getBody()['crypto'];

        Application::$app->controller->redirect("/exchange/$crypto");
    }

    public function crypto(Request $request) {
        $crypto_type = str_replace("/exchange/","",$request->getPath());

        $params = [
            'prices' => $this->getCoinPrices($this->cryptos[$crypto_type],30, 'daily'),
            'crypto_type' => $this->cryptos[$crypto_type]
        ];

        Template::view('exchange.html', $params);
    }

    public function getCoinPrices($coin, $days, $interval)
    {
        $ch = curl_init();
        $coin = strtolower($coin);

        curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3/coins/'.$coin.'/market_chart?vs_currency=eur&days='.$days.'&interval='.$interval);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array();
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $curl_result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        // Decode JSON response:
        $arr_result = json_decode($curl_result, true);

        $prices = $arr_result['prices'];
        for ($i = 0; $i < sizeof($prices); $i++) {
            $prices[$i][0] = $i;
        }

        return $prices;
    }
}