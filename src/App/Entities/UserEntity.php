<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;
use DateTime;

class UserEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_USER;

    /** @var string */
    private $name;

    /** @var string */
    private $password;

    /** @var string */
    private $title;

    //#########################################################

    /**
     * @param array $data
     */
    public function map(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->title = $data['title'] ?? null;

        // defaults
        $this->uuid = $data['uuid'] ?? null;
        $this->loadedAt = $data['loadedAt'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

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
}