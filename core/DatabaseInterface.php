<?php

namespace app\core;

interface DatabaseInterface
{

    function insert($tableName, $columns, $values);

    function update($tableName, $columns, $values, $conditions);

    function select($tableName, $columns,  $conditions, $limit, $offset);

    function delete($tableName, $conditions);

    function fetchFields($tableName);
}