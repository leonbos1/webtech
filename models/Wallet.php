<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;

class Wallet extends DatabaseModel
{

    public static function tableName(): string
    {
        return "wallet";
    }

    public function attributes(): array
    {
        return ['user_id'];
    }

    public static function getWalletByUser($user) {
        return Wallet::findOne(["user_id" => $user->id]);
    }

}