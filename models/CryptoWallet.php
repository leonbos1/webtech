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

    public static function getCryptoWalletsByUser($user) {
        $wallet = Wallet::getWalletByUser($user);
        return CryptoWallet::findAll(["wallet_id" => $wallet->id]);
    }

    public function addEuros($amount) {
        if ($amount > 0) {
            $tablename = self::tableName();
            $old_amount = $this->getEuros();
            $new_amount = $old_amount + $amount;

            $statement = Application::$app->database->connection->prepare("update $tablename set amount = $new_amount 
                    where crypto_wallet_id = $this->crypto_wallet_id and crypto_short = 'eu'");

            $statement->execute();
            Crypto::getAllCryptoNames();
        }
    }


    public function getEuros()
    {
        return CryptoWallet::findOne(['crypto_short'=>'eu'])->amount;
    }


}