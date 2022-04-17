<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;

class WalletController extends Controller
{

    public function index() {
        $params = ['user'=>Application::$app->getUser()];
        return $this->render('wallet',$params);
    }


}