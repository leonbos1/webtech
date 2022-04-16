<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;

class User extends DatabaseModel
{
    public string $username;
    public string $password;

    public static function tableName(): string
    {
        return 'user';
    }

    public function attributes(): array
    {
        return ['username','password'];
    }

    public function register() {
        $options = [
            'cost' => 12,
        ];
        $this->password = password_hash($this->password, PASSWORD_BCRYPT, $options);
        return $this->save();
    }

    public function validate()
    {
        $username = $this->username;
        $pw = $this->password;

        if (User::findOne(['username' => $username])) {
            return 'Username already exists';
        }

        if (strpos($username,' ') !== false || strpos($pw,' ') !== false) {
            return "No spaces allowed in username and password";
        }

        elseif (strlen($pw) < 8) {
            return "Passwords needs to by atleast 8 characters";
        }

        return 'succes';


    }
}