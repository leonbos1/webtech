<?php

namespace app\models;

use app\core\Application;
use app\core\Authentication;
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
        $user_id = Authentication::$auth->getUser()->id;

        if ($amount > 0) {

            $old_amount = self::getEuros($user_id);
            $new_amount = $old_amount + $amount;

            $wallet = Wallet::getWalletByUser(Authentication::$auth->getUser());
            $statement = Application::$app->getDatabase()->connection->prepare("update crypto_wallet
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

    public static function exchangeCurrency($oldCurrency, $amount, $newCurrency) {
        $user_id = Authentication::$auth->getUser()->id;
        $wallet = Wallet::getWalletByUser(Authentication::$auth->getUser());

        if ($amount > 0) {

            $walletExists = false;
            foreach (self::getCryptoWalletsByWalletId($wallet->id) as $cryptoWallet) {
                if ($cryptoWallet['crypto_short'] == $newCurrency) {
                    $walletExists = true;
                }
            }

            if (!$walletExists) {
                $newCryptoWallet = new CryptoWallet();
                $newCryptoWallet->load(['wallet_id' => $wallet->id, 'crypto_short' => $newCurrency, 'amount' => 0]);
                $newCryptoWallet->save();
            }

            $newCurrency_old_amount = self::getAmountOfCurrency($user_id, $newCurrency);
            if ($oldCurrency == 'eu') {
                $newCurrency_new_amount = $newCurrency_old_amount + ($amount / Exchange::getCurrentPrice(Crypto::findOne(['crypto_short'=>$newCurrency])->crypto));
            } elseif ($newCurrency == 'eu') {
                $amount_eur = $amount * Exchange::getCurrentPrice(Crypto::findOne(['crypto_short' => $oldCurrency])->crypto);
                $newCurrency_new_amount = $newCurrency_old_amount + $amount_eur;
            } else {
                $amount_eur = $amount * Exchange::getCurrentPrice(Crypto::findOne(['crypto_short' => $oldCurrency])->crypto);
                $newCurrency_new_amount = $newCurrency_old_amount + ($amount_eur / Exchange::getCurrentPrice(Crypto::findOne(['crypto_short' => $newCurrency])->crypto));
            }

            $oldCurrency_old_amount = self::getAmountOfCurrency($user_id, $oldCurrency);
            $oldCurrency_new_amount = $oldCurrency_old_amount - $amount;
            if ($oldCurrency_new_amount >= 0) {

                $statement = Application::$app->getDatabase()->connection->prepare("update crypto_wallet
                                                                                 set amount = $oldCurrency_new_amount
                                                                                 where wallet_id = $wallet->id and crypto_short = '$oldCurrency'");

                $statement->execute();

                $statement = Application::$app->getDatabase()->connection->prepare("update crypto_wallet
                                                                                 set amount = $newCurrency_new_amount
                                                                                 where wallet_id = $wallet->id and crypto_short = '$newCurrency'");

                $statement->execute();
            }
        }
    }
}