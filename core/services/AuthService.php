<?php

namespace app\core\services;

use app\core\Application;
use app\core\Controller;
use app\core\Response;
use app\models\Session as sessionModel;
use app\models\User;

class AuthService
{

    public function __construct(
        protected Response $response,
    )
    {
    }

    public function LoggedIn() {
        $session_id = $this->response->getCookie('session_id');

        if (!isset($session_id)) {
            return false;
        }

        $session = sessionModel::findOne(['session_id' => $session_id]);

        if (!$session) {
            return false;
        }

        $expire_date = $session->expire_date;
        $expire_date = date_create($expire_date);
        $expire_date = date_add($expire_date, date_interval_create_from_date_string("1 day"));
        $expire_date = date_format($expire_date,"Y-m-d H:m:s");
        $current_date = date("Y-m-d H:m:s");

        if ($current_date > $expire_date) {
            $this->controller->redirect('/logout');
            return false;
        }
        return true;

    }

    public function getUser() {
        $session_id = $this->response->getCookie('session_id');
        $session = sessionModel::findOne(['session_id' => $session_id]);
        $user_id = $session->user_id;
        return User::findOne(['id'=>$user_id]);
    }

    public function isAdmin() {
        $user = $this->getUser();

        if ($user->role != 'admin') {
            return false;
        }
        return true;
    }

}