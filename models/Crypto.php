<?php

namespace app\models;

use app\core\Application;
use app\core\DatabaseModel;

class Crypto extends DatabaseModel
{

    public static function tableName(): string
    {
        return "crypto";
    }

    public function attributes(): array
    {
        return ['crypto_short', 'crypto'];
    }

    public static function getAllCryptoShorts() {
        $result = array();

        $all = Crypto::getAll();

        foreach ($all as $value) {
            $result[] = $value['crypto_short'];
        }

        return $result;
    }

    public static function getAllCryptoNames() {
        $result = array();

        $all = Crypto::getAll();

        foreach ($all as $value) {
            $result[] = $value['crypto'];
        }

        return $result;
    }

}