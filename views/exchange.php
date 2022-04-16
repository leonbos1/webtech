<?php
echo "exchange";

// set API Access Key
$access_key = 'c194de628d8f680f6c98df475e1edaa0';

// Initialize CURL:
$ch = curl_init('http://api.coinlayer.com/live?access_key=' . $access_key . '&target=EUR');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$arr_result = json_decode($json, true);

$BTCPrice = $arr_result['rates']["BTC"];

print($BTCPrice);
?>