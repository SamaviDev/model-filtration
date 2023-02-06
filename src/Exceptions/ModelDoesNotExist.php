<?php

namespace SamaviDev\ModelFiltration\Exceptions;

use InvalidArgumentException;

class ModelDoesNotExist extends InvalidArgumentException
{
    public static function create()
    {
        return new static('No model has been registered yet!');
    }
}
