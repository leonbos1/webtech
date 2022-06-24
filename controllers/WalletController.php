<?php

namespace app\controllers;

use app\core\Application;
use app\core\container\Container;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\core\services\AuthService;
use app\core\Template;
use app\middleware\Unauthorized;
use app\models\CryptoWallet;
use app\models\User;
use app\models\Wallet;

class WalletController extends Controller
{

    public function __construct(protected Controller $controller,
                                protected AuthService $authService,
                                protected Request $request,
                                protected Response $response)
    {
        $this->addMiddleware(new Unauthorized(['wallet'], $this->authService, $this->controller, $this->response));

    }

    public function wallet() {

        $user = $this->authService->getUser();
        $wallet = Wallet::getWalletByUser($user);

        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);
        $currencies = array();
        $amounts = array();

        foreach ($cryptowallets as $cryptowallet) {
            $currencies[] = $cryptowallet['crypto_short'];
            $amounts[] = $cryptowallet['amount'];
        }

        $params = [
            'user'=>$user,
            'currencies'=>$currencies,
            'amount'=>$amounts,
            ];

        Template::view('layouts/wallet.html', $params);
    }

    public function addEuros() {

        $amount = $this->request->getBody()['add_euro'];

        CryptoWallet::addEuro($amount);

        $this->controller->redirect('/wallet');
    }
}