<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class UserRoleEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_USER;

    /** @var string */
    private $userUuid;

    /** @var string */
    private $roleUuid;

    //#########################################################

    /**
     * @param array $data
     */
    public function load(array $data)
    {
        $this->userUuid = $data['userUuid'] ?? null;
        $this->roleUuid = $data['roleUuid'] ?? null;

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

    /**
     * @return string
     */
    public function getRoleUuid(): string
    {
        return $this->roleUuid;
    }

    /**
     * @param string $roleUuid
     */
    public function setRoleUuid(string $roleUuid): void
    {
        $this->roleUuid = $roleUuid;
    }

}