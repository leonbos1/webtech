<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\core\Template;

class ExchangeController extends Controller
{
    public function exchange() {
        $params = [];
        Template::view('exchange.html', ['prices' => $this->getCoinPrices('bitcoin',30, 'daily')]);
    }

    public function crypto($crypto) {
        Template::view('exchange.html', ['crypto' => $crypto]);
    }

    public function getCoinPrices($coin, $days, $interval)
    {
        $ch = curl_init();

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