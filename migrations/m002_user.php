<?php

use app\core\Application;
use app\models\User;

class m002_user {

    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                role varchar(45),
                FOREIGN KEY (role) references role(name)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);

        $user = new User();
        $user->load(['username'=>'admin','password'=>'admin123','role'=>'admin']);
        $user->register();
    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE user;";
        $database->connection->exec($statement);
    }
}