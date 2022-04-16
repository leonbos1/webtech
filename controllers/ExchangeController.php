<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

include 'core/Template.php';

class ExchangeController extends Controller
{
    public function exchange() {
        $params = [];
        Template::view('exchange.html', ['coins' => $this->getCoinsData()]);
    }

    public function handlePost(Request $req) {

        $body = $req->getBody();

        echo $body['kaas'];

    }

    public function getCoinsData()
    {
        // Initialize CURL:
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3/coins/bitcoin');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array();
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch))
        {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        // Decode JSON response:
        $arr_result = json_decode($result, true);

        print_r($arr_result);
    }
}