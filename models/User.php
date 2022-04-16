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
        return $this->save();
    }

    public function validate()
    {
        return [
            'username' => ['required'],
            'password' => ['required']
        ];
    }
}