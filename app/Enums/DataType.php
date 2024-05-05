<?php

namespace App\Enums;

enum DataType: string
{
    case INTEGER = 'integer';
    case DECIMAL = 'decimal';
    case DOUBLE = 'double';
    case STRING = 'string';
    case BOOLEAN = 'bool';
}
