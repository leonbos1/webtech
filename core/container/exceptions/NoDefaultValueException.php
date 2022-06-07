<?php

namespace app\core\container\exceptions;

use app\core\container\NotFoundExceptionInterface;
use Exception;

class NoDefaultValueException extends Exception implements NotFoundExceptionInterface
{

    public function __construct()
    {

    }
}