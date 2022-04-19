<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;

class Wallet extends DatabaseModel
{
    public int $user_id;
    public int $euro;
    public int $BTC;
    public int $ETH;
    public int $LTC;
    public int $XRP;
    public int $DOGE;

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

    public function addEuros($amount) {
        $tablename = self::tableName();
        $new_amount = $this->euro + $amount;
        $statement = Application::$app->database->connection->prepare("update $tablename set euro = $new_amount where user_id = $this->user_id");

        $statement->execute();
    }

    public function convertCurrency($beforeConvert, $afterConvert, $amount) {

        // $newAmount = ($amount * omgerekende waarde)
        // oldAmountBeforeConvert = totale beforeConvert
        // newAmountBeforeConvert = oldAmountBeforeConvert - $amount
        // update in database beforeConvert = beforeConvert = newAmountBeforeConvert
        // oldAmountAfterConvert = totale afterConvert
        // newAmountAfterConvert = oldAmountAfterConvert + $newAmount
        // update in database afterConvert = afterConvert = newAmountAfterConvert

    }

}