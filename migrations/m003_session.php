<?php

use app\core\Application;

class m003_session
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE session (
                session_id varchar(45) primary key ,
                user_id INT,
                create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                expire_date TIMESTAMP DEFAULT adddate(CURRENT_TIMESTAMP, INTERVAL 1 DAY),
                last_access TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) references user(id)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $db = Application::$app->db;
        $SQL = "DROP TABLE session;";
        $db->pdo->exec($SQL);
    }
}