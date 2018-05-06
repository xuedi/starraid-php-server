<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class CargoEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_CARGO;

    public function map(array $data)
    {
        // TODO: Implement map() method.
    }
}