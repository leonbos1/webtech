<?php

namespace app\controllers;

use app\core\Controller;

class PortfolioController extends Controller
{

    public function portfolio() {
        $params = [];

        return $this->render('portfolio',$params);
    }


}