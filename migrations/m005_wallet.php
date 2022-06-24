<?php

use app\core\Application;
use app\models\Wallet;

class m005_wallet
{
    public function up() {
        $database = Application::$app->getDatabase();
        $statement = "CREATE TABLE wallet (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) references user(id)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);

        //wallet aanmaken voor standaard admin account
        $wallet = new Wallet();
        $wallet->load(['user_id'=>'1']);
        $wallet->save();
    }

    public function down() {
        $database = Application::$app->getDatabase();
        $statement = "DROP TABLE wallet;";
        $database->connection->exec($statement);
    }
}