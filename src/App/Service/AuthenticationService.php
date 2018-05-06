<?php

namespace App\Service;

use App\Entities\ActiveUser;
use App\Entities\Authentication;
use App\Entities\Interfaces\Database;
use App\Entities\SpaceshipEntity;
use App\Entities\UserEntity;
use DateTime;

/**
 * Class AuthenticationService
 * @package App\Service
 */
class AuthenticationService
{
    /** @var string */
    private $appToken;

    /** array */
    private $activeUsers = null;

    /** ObjectService */
    private $objectService = null;

    /** @var ObjectService */
    private static $instance;

    /**
     * AuthenticationService constructor.
     * @param string $appToken
     */
    private function __construct(string $appToken)
    {
        $this->appToken = null;
        $this->activeUsers = [];
        $this->objectService = ObjectService::getInstance();
    }

    /**
     * @param string|null $appToken
     * @return AuthenticationService|ObjectService
     */
    public static function getInstance(string $appToken = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = new AuthenticationService($appToken);
        }
        return self::$instance;
    }

    /**
     * @param string $user
     * @param string $pass
     * @return array
     */
    public function authenticate(string $user, string $pass): array
    {
        $token = null;
        $success = false;
        $users = $this->objectService->getObjects('user');

        /** @var UserEntity $userEntity */
        foreach ($users as $key => $userEntity) {
            if ($userEntity->getName() == $user && $userEntity->getPassword() == $pass && $success == false) {
                $token = $this->activateUser($userEntity);
                $success = true;
            }
        }
        return [
            'success' => $success,
            'token' => $token,
        ];
    }

    /**
     * Update laag
     */
    public function tick()
    {
        /** @var ActiveUser $activeUser */
        foreach ($this->activeUsers as $token => $activeUser) {
            $activeUser->increaseLaag();
            $this->activeUsers[$token] = $activeUser;
        }
    }

    /**
     * Update laag
     */
    public function getList()
    {
        $userList = [];
        /** @var ActiveUser $activeUser */
        foreach ($this->activeUsers as $token => $activeUser) {
            $userList[$token] = $activeUser;
        }
        return $userList;
    }

    /**
     * @param UserEntity $userEntity
     * @return string
     */
    private function activateUser(UserEntity $userEntity): string
    {
        $userUuid = $userEntity->getUuid();
        $token = $this->getToken($userUuid);
        if (!empty($token)) {
            return $token;
        }

        $activeUser = new ActiveUser();
        $activeUser->setUserUuid($userUuid);
        $activeUser->setUserName($userEntity->getName());
        $activeUser->setLoginAt(new DateTime());
        $activeUser->setLaagCount(0);

        $token = md5($this->appToken . '-' . md5($userUuid) . '-' . rand(0, 10000));
        $this->activeUsers[$token] = $activeUser;

        return $token;
    }

    /**
     * @param string $userUuid
     * @return null|string
     */
    private function getToken(string $userUuid): ?string
    {
        /** @var ActiveUser $activeUser */
        foreach ($this->activeUsers as $token => $activeUser) {
            if ($activeUser->getUserUuid() == $userUuid) {
                return $token;
            }
        }
        return null;
    }
}