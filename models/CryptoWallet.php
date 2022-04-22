<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;

class CryptoWallet extends DatabaseModel
{

    public static function tableName(): string
    {
        return "crypto_wallet";
    }

    public function attributes(): array
    {
        return ['crypto_wallet_id', 'wallet_id', 'crypto_short', 'amount'];
    }

    public static function getCryptoWalletByUser($user) {
        $wallet = Wallet::getWalletByUser($user);
        return CryptoWallet::findOne(["wallet_id" => $wallet->id]);
    }

    public function addEuros($amount, $user) {
        $tablename = self::tableName();
        $new_amount = $this->getEuros() + $amount;
        $wallet = Wallet::getWalletByUser($user);

        $statement = Application::$app->database->connection->prepare("update $tablename set amount = $new_amount where wallet_id = $wallet->id and crypto_short = eu");

        $statement->execute();
    }

    public function getEuros($user)
    {
        $wallet = Wallet::getWalletByUser($user);

        return CryptoWallet::findOne(['wallet_id'=>$wallet->id, 'crypto_short'=>'eu'])->amount;
    }


}