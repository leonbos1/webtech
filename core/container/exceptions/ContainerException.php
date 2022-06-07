<?php

namespace app\core\container\exceptions;

use app\core\container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
    }
}