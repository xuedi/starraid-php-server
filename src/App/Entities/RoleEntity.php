<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;
use JsonSerializable;

class RoleEntity extends AbstractObject implements Database, JsonSerializable
{
    protected static $tableName = self::TYPE_ROLE;

    /** @var string */
    private $name;

    //#########################################################

    /**
     * @param array $data
     */
    public function load(array $data)
    {
        $this->name = $data['name'] ?? null;

        // defaults
        $this->uuid = $data['uuid'] ?? null;
        $this->loadedAt = $data['loadedAt'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
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
            'name' => $this->name,
            'loadedAt' => $this->loadedAt,
            'createdAt' => $this->createdAt->format('c'),
        ];
    }

    //#########################################################

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}