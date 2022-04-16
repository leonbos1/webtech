<?php

use app\core\Application;

class m002_wallet
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE wallet (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                euro DECIMAL,
                BTC decimal,
                ETH decimal,
                LTC decimal,
                XRP decimal,
                DOGE decimal,
                last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) references user(id)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $db = Application::$app->db;
        $SQL = "DROP TABLE wallet;";
        $db->pdo->exec($SQL);
    }
}