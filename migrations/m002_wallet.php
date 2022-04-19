<?php

use app\core\Application;

class m002_wallet
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE wallet (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                euro DECIMAL not null default 0,
                BTC decimal not null default 0,
                ETH decimal not null default 0,
                LTC decimal not null default 0,
                XRP decimal not null default 0,
                DOGE decimal not null default 0,
                last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) references user(id)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE wallet;";
        $database->connection->exec($statement);
    }
}