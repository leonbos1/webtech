<?php

use app\core\Application;

class m001_role
{
    public function up() {
        $database = Application::$app->database;
        $statement = "CREATE TABLE role (
                name varchar(45) primary key
            )  ENGINE=INNODB;";
        $database->connection->exec($statement);

        $roles = ['admin', 'tier1', 'tier2'];
        foreach ($roles as $role) {
            $statement = "INSERT INTO ROLE (name)
                    values ('$role')";
            $database->connection->exec($statement);
        }

    }

    public function down() {
        $database = Application::$app->database;
        $statement = "DROP TABLE role;";
        $database->connection->exec($statement);
    }
}