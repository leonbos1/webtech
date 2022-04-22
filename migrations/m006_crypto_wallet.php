<?php

use app\core\Application;

class m006_crypto_wallet
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE crypto_wallet (
                crypto_wallet_id int primary key,
                wallet_id int not null,
                crypto_short varchar(45) not null,
                amount int,
                FOREIGN KEY (wallet_id) references wallet(id),
                FOREIGN KEY (crypto_short) references crypto(crypto_short)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE crypto_wallet;";
        $database->connection->exec($statement);
    }
}