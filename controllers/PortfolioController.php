<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Template;

class PortfolioController extends Controller
{

    public function portfolio() {
        $params = [];

        Template::view('portfolio.html', $params);
    }


}