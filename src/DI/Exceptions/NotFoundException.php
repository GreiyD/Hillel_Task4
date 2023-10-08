<?php

namespace App\DI\Exceptions;

use App\DI\Interfaces\NotFoundExceptionInterface;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}