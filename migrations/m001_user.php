<?php

use app\core\Application;

class m001_user {

    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $db = Application::$app->db;
        $SQL = "DROP TABLE user;";
        $db->pdo->exec($SQL);
    }
}