<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class Login extends Model
{

    public string $username;
    public string $password;

    public function login() {

        $user = User::findOne(['username' => $this->username]);

        if (!$user) {
            return false;
        }

        if ($this->username === $user->username && $this->password === $user->password) {
            return true;
        }
        return false;


    }


}