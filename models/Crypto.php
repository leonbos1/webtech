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

}