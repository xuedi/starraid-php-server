<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;
use JsonSerializable;

class CargoEntity extends AbstractObject implements Database, JsonSerializable
{
    protected static $tableName = self::TYPE_CARGO;

    public function load(array $data)
    {
        // TODO: Implement map() method.
    }

    /**
     * @return array
     */
    public function mapping() : array
    {
        return [];
    }

    public function jsonSerialize()
    {
        return [
            'uuid' => $this->uuid,
            'loadedAt' => $this->loadedAt,
            'createdAt' => ($this->createdAt) ? $this->createdAt->format('c') : null,
        ];
    }
}