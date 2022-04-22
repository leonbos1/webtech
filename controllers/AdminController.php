<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

use app\core\Template;
use app\middleware\IsAdmin;
use app\middleware\Unauthorized;
use app\models\Crypto;
use app\models\Exchange;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->addMiddleware(new Unauthorized(['admin']));
        $this->addMiddleware(new IsAdmin(['admin']));
    }

    public function admin() {

        $params = [];

        Template::view('layouts/adminpanel.html', $params);
    }

   public function addCrypto(Request $request) {

       $crypto = new Crypto();

       $crypto->load($request->getBody());

       if (Crypto::findOne(['crypto_short'=>$crypto->crypto_short]) == null) {

           $crypto->save();
       }
       Application::$app->controller->redirect('/admin');

   }
}