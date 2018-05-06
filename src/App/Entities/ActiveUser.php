<?php

namespace App\Entities;

use DateTime;
use JsonSerializable;

/**
 * Class ActiveUser
 * @package App\Entities
 */
class ActiveUser implements JsonSerializable
{
    /** @var string */
    private $userUuid;

    /** @var string */
    private $userName;

    /** @var DateTime */
    private $loginAt;

    /** @var int */
    private $laagCount;

    //#########################################################

    public function increaseLaag(): void
    {
        $this->laagCount++;
    }

    public function jsonSerialize()
    {
        return [
            'userUuid' => $this->userUuid,
            'userName' => $this->userName,
            'laagCount' => $this->laagCount,
            'loginAt' => ($this->loginAt) ? $this->loginAt->format('c') : null,
        ];
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
     * @return DateTime
     */
    public function getLoginAt(): DateTime
    {
        return $this->loginAt;
    }

    /**
     * @param DateTime $loginAt
     */
    public function setLoginAt(DateTime $loginAt): void
    {
        $this->loginAt = $loginAt;
    }

    /**
     * @return int
     */
    public function getLaagCount(): int
    {
        return $this->laagCount;
    }

    /**
     * @param int $laagCount
     */
    public function setLaagCount(int $laagCount): void
    {
        $this->laagCount = $laagCount;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }
}