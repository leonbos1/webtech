<?php

namespace app\models;

class Exchange
{

    public static function getCoinPrices($coin, $days, $interval)
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

    public static function getCurrentPrice($coin) {
        $ch = curl_init();
        $coin = strtolower($coin);

        curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3/coins/'.$coin.'/market_chart?vs_currency=eur&days=1&interval=daily');
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

        return $arr_result['prices'][1][1];
    }

}