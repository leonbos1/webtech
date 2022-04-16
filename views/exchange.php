<?php
echo "exchange";

/*
// set API Access Key
$access_key = 'c194de628d8f680f6c98df475e1edaa0';

// Initialize CURL:
$ch = curl_init('http://api.coinlayer.com/live?access_key=' . $access_key . '&target=EUR');



// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$arr_result = json_decode($json, true);

$BTCPrice = $arr_result['rates']["BTC"];

print($BTCPrice);
*/

// Initialize CURL:

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

curl_setopt($ch, CURLOPT_URL, 'https://api.coingecko.com/api/v3/coins/bitcoin');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

$headers = array();
$headers[] = 'Accept: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

// Decode JSON response:
$arr_result = json_decode($result, true);

print_r($arr_result);
?>