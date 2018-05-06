<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class CargoEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_CARGO;

    public function load(array $data)
    {
        // TODO: Implement map() method.
    }

    /**
     * @return array
     */
    public function map() : array
    {
        return [];
    }
}