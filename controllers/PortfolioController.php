<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;
use app\models\Exchange;
use app\models\Wallet;

class PortfolioController extends Controller
{
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

        $params = [
            'user'=>$user,
            'wallet'=>$wallet,
            'cryptos'=>$this->cryptos
        ];

        Template::view('layouts/portfolio.html', $params);
    }

    public function trade(Request $request) {
        $firstCurrency = $request->getBody()['firstcurrency'];
        $secondCurrency = $request->getBody()['secondcurrency'];
        $amount = $request->getBody()['amount'];

        var_dump( Exchange::getCoinPrices() );

        $params = [];

        Template::view('layouts/portfolio.hmtl', $params);
    }

}