<?php

use app\core\Application;

class m003_session
{
    public function up() {
        $database = Application::$app->getDatabase();
        $statement = "CREATE TABLE session (
                session_id varchar(45) primary key ,
                user_id INT,
                create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                expire_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) references user(id)
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);
    }

    public function down() {
        $database = Application::$app->getDatabase();
        $statement = "DROP TABLE session;";
        $database->connection->exec($statement);
    }
}