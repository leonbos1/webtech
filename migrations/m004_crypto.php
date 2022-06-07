<?php

use app\core\Application;

class m004_crypto
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE crypto (
                crypto_short varchar(45) primary key ,
                crypto varchar(45)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);

        $statement1 = "insert into crypto (crypto_short, crypto) values ('eu','Euro')";
        $statement2 = "insert into crypto (crypto_short, crypto) values ('xrp','Ripple')";
        $statement3 = "insert into crypto (crypto_short, crypto) values ('btc','Bitcoin')";
        $statement4 = "insert into crypto (crypto_short, crypto) values ('ltc','Litecoin')";
        $statement5 = "insert into crypto (crypto_short, crypto) values ('doge','Dogecoin')";
        $database->connection->exec($statement1);
        $database->connection->exec($statement2);
        $database->connection->exec($statement3);
        $database->connection->exec($statement4);
        $database->connection->exec($statement5);
    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE crypto;";
        $database->connection->exec($statement);
    }
}