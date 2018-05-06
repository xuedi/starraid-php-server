<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class SpaceshipEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_SPACESHIP;

    /** @var string */
    private $title;

    /** @var int */
    private $x;

    /** @var int */
    private $y;

    /** @var string */
    private $userUuid;

    //#########################################################

    /**
     * @param array $data
     * @return mixed|void
     */
    public function load(array $data)
    {
        $this->userUuid = $data['userUuid'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->x = $data['x'] ?? null;
        $this->y = $data['y'] ?? null;

        // defaults
        $this->uuid = $data['uuid'] ?? null;
        $this->loadedAt = $data['loadedAt'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
    }

    /**
     * @return array
     */
    public function map() : array
    {
        return [];
    }

    //#########################################################

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }

    /**
     * @return string
     */
    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    /**
     * @param string $userUuid
     */
    public function setUserUuid(string $userUuid): void
    {
        $this->userUuid = $userUuid;
    }
}