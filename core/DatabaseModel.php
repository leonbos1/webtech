<?php

namespace app\core;

use app\core;
use app\core\Application;
use app\core\Model;


abstract class DatabaseModel extends Model {

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attribute = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attribute);

        $statement = Application::$app->database->connection->prepare("insert into $tableName (" . implode(',', $attribute) . ")
                                                              values(" . implode(',', $params) . ")");

        foreach ($attribute as $value) {
            $statement->bindValue(":$value", $this->{$value});
        }

        $statement->execute();

        return true;

    }


}