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

    public static function getAmountOfCurrency($user_id, $currency)
    {
        $user = User::findOne(['id'=>$user_id]);
        echo $user->username;
        exit();
        $wallet = Wallet::getWalletByUser($user);
        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);

        foreach ($cryptowallets as $cryptowallet) {
            if ($cryptowallet['crypto_short'] == $currency) {
                return $cryptowallet['amount'];
            }
        }
    }

    public function attributes(): array
    {
        return ['wallet_id', 'crypto_short', 'amount'];
    }

    public static function getCryptoWalletsByUser($user) {
        $wallet = Wallet::getWalletByUser($user);
        return CryptoWallet::findAll(["wallet_id" => $wallet->id]);
    }

    public static function getCryptoWalletsByWalletId($wallet_id) {
        return CryptoWallet::findAll(["wallet_id" => $wallet_id]);
    }

    public static function addEuro($amount) {
        $user_id = Application::$app->getUser()->id;

        if ($amount > 0) {

            $old_amount = self::getEuros($user_id);
            $new_amount = $old_amount + $amount;

            $wallet = Wallet::getWalletByUser(Application::$app->getUser());
            $statement = Application::$app->database->connection->prepare("update crypto_wallet
                                                                                 set amount = $new_amount
                                                                                 where wallet_id = $wallet->id and crypto_short = 'eu'");

            $statement->execute();
        }
    }

    public static function getEuros($user_id)
    {
        $user = User::findOne(['id'=>$user_id]);
        $wallet = Wallet::getWalletByUser($user);
        $cryptowallets = CryptoWallet::findAll(['wallet_id'=>$wallet->id]);

        foreach ($cryptowallets as $cryptowallet) {
            if ($cryptowallet['crypto_short'] == 'eu') {
                return $cryptowallet['amount'];
            }
        }
    }
}