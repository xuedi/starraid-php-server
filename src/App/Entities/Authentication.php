<?php

namespace App\Entities;

use DateTime;

/**
 * Class Authentication
 * @package App\Entities
 */
class Authentication
{

    /** @var string */
    private $userUuid;

    /** @var DateTime */
    private $loginAt;

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
}