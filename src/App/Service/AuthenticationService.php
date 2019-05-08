<?php

namespace App\Service;

use App\Entities\ActiveUser;
use App\Entities\UserEntity;
use DateTime;
use Exception;

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

    /**
     * AuthenticationService constructor.
     * @param ObjectService $objectService
     * @param string $appToken
     */
    public function __construct(ObjectService $objectService, string $appToken)
    {
        $this->activeUsers = [];
        $this->appToken = $appToken;
        $this->objectService = $objectService;
    }

    /**
     * @param string|null $user
     * @param string|null $pass
     * @return array
     * @throws Exception
     */
    public function authenticate(string $user = null, string $pass = null): array
    {
        $token = null;
        $success = false;
        $users = $this->objectService->getObjectGroup('user');

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
            if($activeUser->getLaagCount() >= 10) {
                unset($this->activeUsers[$token]);
                continue;
            }
            $activeUser->increaseLaag();
            $this->activeUsers[$token] = $activeUser;
        }
    }

    /**
     * @return array
     */
    public function getList(): array
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
     * @throws Exception
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