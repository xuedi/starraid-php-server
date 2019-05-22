<?php declare(strict_types = 1);

namespace App\Entities;

use App\Entities\Interfaces\Database;
use DateTime;
use JsonSerializable;

class UserEntity extends AbstractEntity implements Database, JsonSerializable
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
     * @throws \Exception
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
        $this->createdAt = new DateTime($data['createdAt']) ?? null;
    }

    /**
     * Does the mapping of sub entities
     * @return array
     */
    public function mapping(): array
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

    public function jsonSerialize()
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'title' => $this->title,
            'roles' => $this->roles,
            'loadedAt' => $this->loadedAt,
            'createdAt' => ($this->createdAt) ? $this->createdAt->format('c') : null,
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