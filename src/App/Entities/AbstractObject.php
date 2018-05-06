<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;
use DateTime;
use Exception;

/**
 * Class AbstractObject
 * @package App\Entities
 */
abstract class AbstractObject
{
    protected static $tableName = null;

    const TYPES = [
        Database::TYPE_SPACESHIP,
        Database::TYPE_CARGO,
        Database::TYPE_USER,
        Database::TYPE_ROLE,
        Database::TYPE_USER_ROLE,
    ];

    /** @var string */
    protected $uuid;

    /** @var int */
    protected $loadedAt;

    /** @var null|DateTime */
    protected $createdAt;

    //#########################################################

    /**
     * @return string
     * @throws Exception
     */
    public function getTableName(): string
    {
        if (!in_array($this::$tableName, self::TYPES)) {
            throw new Exception("Table {$this::$tableName} is not a valid type");
        }
        return $this::$tableName;
    }

    //#########################################################

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getLoadedAt(): int
    {
        return $this->loadedAt;
    }

    /**
     * @param int $loadedAt
     */
    public function setLoadedAt(int $loadedAt): void
    {
        $this->loadedAt = $loadedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}