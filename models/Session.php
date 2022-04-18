<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;
use app\core\Response;

class Session extends DatabaseModel
{

    public string $session_id;
    public int $user_id;

    public static function tableName(): string
    {
        return 'session';
    }

    public function attributes(): array
    {
        return ['session_id','user_id','create_date','expire_date','last_access'];
    }

    public function login($username) {
        $user = User::findOne(['username' => $username]);

        $this->session_id = $this->generateRandomString(12);
        $this->user_id = $user->id;

        Application::$app->response->setCookie('session_id',$this->session_id, time()+86400);

        $this->save();

    }

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}