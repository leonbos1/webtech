<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\services\AuthService;
use app\core\Template;
use app\middleware\IsAdmin;
use app\middleware\Unauthorized;
use app\models\Crypto;

class AdminController extends Controller
{
    public function __construct(protected AuthService $authService, protected Controller $controller)
    {
        $this->addMiddleware(new Unauthorized(['admin'], $this->authService));
        $this->addMiddleware(new IsAdmin(['admin'], $this->authService));
        $this->container = Application::$app->getContainer();
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
       $this->controller->redirect('/admin');

   }
}