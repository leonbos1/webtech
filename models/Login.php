<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class Login extends Model
{

    public string $username;
    public string $password;

    public function validLogin() {

        if (strpos($this->username,' ') !== false || strpos($this->password, ' ') !== false) {
            return "Invalid combination";
        }

        $user = User::findOne(['username' => $this->username]);

        if (!$user) {
            return "Invalid username and/or password";
        }

        if ($this->username === $user->username && password_verify($this->password, $user->password)) {
            return 'succes';
        }
        return "Invalid username and/or password";


    }


}