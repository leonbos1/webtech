<?php

namespace app\core;

use PDO;

class Database
{

    public \PDO $connection;

    public function __construct(array $config) {
        $domain_service_name = $config['dsn'];
        $username = $config['username'];
        $password = $config['password'];

        $this->connection = new PDO($domain_service_name, $username,$password);
        $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    }

    public function migrations() {
        $this->createTable();
        $migrations = $this->getMigrations();

        $newMigrations = [];
        $files = scandir(Application::$root_directory.'/migrations');
        //$applyMigrations = array_diff($files, $migrations);

        foreach ($files as $mig) {

            if ($mig !== '.' && $mig !== '..') {
                require_once Application::$root_directory . '/migrations/' . $mig;
                $filename = pathinfo($mig, PATHINFO_FILENAME);
                $classname = new $filename();

                $classname->up();
                $newMigrations[] = $mig;
            }
        }
        if (!empty($newMigrations)) {
            $this->saveMigration($newMigrations);
        } else {
            echo "All migrations applied";
        }

    }

    public function createTable() {

        $this->connection->exec("create table if not exists migrations (
            id int auto_increment primary key,
            migration varchar(255),
            created_at timestamp default current_timestamp
        ) engine=innodb;");
    }

    public function getMigrations() {

        $statement = $this->connection->prepare("select migration from migrations");
        $statement->execute();

        return $statement->fetchAll($this->connection::FETCH_COLUMN);

    }

    public function saveMigration(array $migrations)
    {
        $string = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $executable = $this->connection->prepare("insert into migrations (migration) values
        $string
        ");
        $executable->execute();

    }
}