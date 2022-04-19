<?php

namespace app\models;

use app\core\DatabaseModel;

class Wallet extends DatabaseModel
{
    public static function tableName(): string
    {
        return "wallet";
    }

    public function attributes(): array
    {
        return ["user_id", "euro","BTC","ETH","LTC","XRP","DOGE"];
    }

    public static function getWalletByUser($user) {
        return Wallet::findOne(["user_id" => $user->id]);
    }

}