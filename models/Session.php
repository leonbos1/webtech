<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;
use app\core\Response;

class Session extends DatabaseModel
{

    public string $session_id;
    public int $user_id;
    public string $expire_date;

    public static function tableName(): string
    {
        return 'session';
    }

    public function attributes(): array
    {
        return ['session_id','user_id','expire_date'];
    }

    public function login($username) {
        $user = User::findOne(['username' => $username]);

        $this->session_id = $this->generateRandomString(12);
        $this->user_id = $user->id;

        $expire_date = date_create(date("Y-m-d H:m:s"));
        $expire_date = date_add($expire_date, date_interval_create_from_date_string("1 day"));
        $this->expire_date = date_format($expire_date,"Y-m-d H:m:s");

        Application::$app->container->resolve(Response::class)->setCookie('session_id',$this->session_id, time()+86400);

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