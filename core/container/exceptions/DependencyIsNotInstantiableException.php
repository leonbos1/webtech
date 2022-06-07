<?php

namespace app\core\container\exceptions;

use app\core\container\NotFoundExceptionInterface;
use Exception;

class DependencyIsNotInstantiableException extends Exception implements NotFoundExceptionInterface
{
}