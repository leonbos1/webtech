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
    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE crypto;";
        $database->connection->exec($statement);
    }
}