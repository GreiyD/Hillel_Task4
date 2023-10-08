<?php

namespace App\DI\Exceptions;

use App\DI\Interfaces\ContainerExceptionInterface;
use Exception;

class ContainerException extends Exception implements ContainerExceptionInterface
{

}