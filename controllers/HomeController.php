<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Template;

class HomeController extends Controller
{

    public function home() {
        $params = [];
        Template::view('home.html', $params);
    }

    public function handlePost(Request $req) {}

}