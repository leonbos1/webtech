<?php

namespace app\core;

use app\core;
use app\core\Application;
use app\core\Model;


abstract class DatabaseModel extends Model {

    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attribute = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attribute);

        $statement = Application::$app->getDatabase()->connection->prepare("insert into $tableName (" . implode(',', $attribute) . ")
                                                              values(" . implode(',', $params) . ")");

        foreach ($attribute as $value) {
            $statement->bindValue(":$value", $this->{$value});
        }

        $statement->execute();

        return true;

    }

    public static function findOne($where) {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $query = implode("AND ",array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->getDatabase()->connection->prepare("select * from $tableName where $query");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key",$item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function findAll($where) {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $query = implode("AND ",array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = Application::$app->getDatabase()->connection->prepare("select * from $tableName where $query");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key",$item);
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public static function getAll() {
        $tableName = static::tableName();

        $statement = Application::$app->getDatabase()->connection->prepare("select * from $tableName");

        $statement->execute();
        return $statement->fetchAll();
    }

}