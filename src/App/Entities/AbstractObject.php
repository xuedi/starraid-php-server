<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;
use Exception;

abstract class AbstractObject
{
    const TABLE = null;
    const TYPES = [
        Database::TYPE_SPACESHIP,
        Database::TYPE_CARGO,
    ];

    public function load()
    {
        // do DB load by type
    }

    public function save()
    {
        // do DB save by type
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getTable(): string
    {
        if (!in_array(self::TABLE, self::TYPES)) {
            throw new Exception('Table ' . self::TABLE . ' is not a valid type');
        }
        return self::TABLE;
    }
}