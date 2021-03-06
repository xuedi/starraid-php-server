<?php declare(strict_types = 1);

namespace App\Entities\Interfaces;

interface Database
{
    const TYPE_SPACESHIP = 'spaceship';
    const TYPE_CARGO = 'cargo';
    const TYPE_USER = 'user';
    const TYPE_ROLE = 'role';
    const TYPE_USER_ROLE = 'user_role';

    /**
     * @param array $data
     * @return mixed
     */
    public function load(array $data);

    /**
     * @return array
     */
    public function mapping(): array;

    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void;

    /**
     * @return int
     */
    public function getLoadedAt(): int;

    /**
     * @param int $loadedAt
     */
    public function setLoadedAt(int $loadedAt): void;
}