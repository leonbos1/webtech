<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\models\Exchange;

class PortfolioController extends Controller
{
    protected array $cryptos = [
        'btc' => 'Bitcoin',
        'xrp' => 'Ripple',
        'ltc' => 'Litecoin',
        'doge' => 'Dogecoin',
        'eth' =>'Ethereum'
    ];

    public function portfolio() {
        $params = [];

        Template::view('portfolio.html', $params);
    }

    public function trade(Request $request) {
        $firstCurrency = $request->getBody()['firstcurrency'];
        $secondCurrency = $request->getBody()['secondcurrency'];
        $amount = $request->getBody()['amount'];

        var_dump( Exchange::getCoinPrices() );

        $params = [];

        Template::view('portfolio.hmtl', $params);
    }

}