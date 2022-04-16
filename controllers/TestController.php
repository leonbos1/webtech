<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class TestController extends Controller
{

    public function get() {
        $params = [];
        return $this->render('test',$params);
    }

    public function post() {

    }

}