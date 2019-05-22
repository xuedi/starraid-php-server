<?php declare(strict_types = 1);

namespace App\Entities;

use App\Entities\Interfaces\Database;
use JsonSerializable;

class CargoEntity extends AbstractEntity implements Database, JsonSerializable
{
    protected static $tableName = self::TYPE_CARGO;

    /**
     * @param array $data
     * @return mixed|void
     */
    public function load(array $data)
    {
        // TODO: Implement map() method.
    }

    /**
     * @return array
     */
    public function mapping(): array
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