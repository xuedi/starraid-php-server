<?php

namespace App\Entities;

use App\Entities\Interfaces\Database;

class UserEntity extends AbstractObject implements Database
{
    protected static $tableName = self::TYPE_USER;

    /** @var string */
    private $name;

    /** @var string */
    private $password;

    /** @var string */
    private $title;

    /** @var RoleEntity[] */
    private $roles;

    //#########################################################

    /**
     * @param array $data
     */
    public function load(array $data)
    {
        $this->name = $data['name'] ?? null;
        $this->password = $data['password'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->roles = $data['roles'] ?? null;

        // defaults
        $this->uuid = $data['uuid'] ?? null;
        $this->loadedAt = $data['loadedAt'] ?? null;
        $this->createdAt = $data['createdAt'] ?? null;
    }

    /**
     * Does the mapping of sub entities
     * @return array
     */
    public function map(): array
    {
        return [
            'setRoles' => [
                [
                    'table' => 'user_role',
                    'getterFindBy' => 'getUserUuid',
                    'getterSearch' => 'getRoleUuid',
                ],
                [
                    'table' => 'role',
                    'getterFindBy' => 'getUuid',
                    'getterSearch' => 'getUuid', // finally
                ],
            ],
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

    /**
     * @return RoleEntity[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param RoleEntity[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}