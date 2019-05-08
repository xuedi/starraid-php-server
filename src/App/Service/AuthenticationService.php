<?php

namespace App\Service;

use App\Entities\ActiveUser;
use App\Entities\UserEntity;
use App\Exceptions\AuthenticationException;
use DateTime;
use Exception;

/**
 * Class AuthenticationService
 * @package App\Service
 */
class AuthenticationService
{
    const ROLE_USER = 10;
    const ROLE_ADMIN = 100;

    /** @var string */
    private $appSalt;

    /** array */
    private $activeUsers = null;

    /** ObjectService */
    private $objectService = null;

    /**
     * AuthenticationService constructor.
     * @param ObjectService $objectService
     * @param string $appSalt
     */
    public function __construct(ObjectService $objectService, string $appSalt)
    {
        $this->activeUsers = [];
        $this->appSalt = $appSalt;
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
            if ($userEntity->getName() == $user && $userEntity->getPassword() == $pass) {
                $token = $this->activateUser($userEntity);
                $success = true;
                break;
            }
        }
        return [
            'success' => $success,
            'token' => $token,
        ];
    }

    /**
     * @param int $demandLevel
     * @param string|null $token
     * @throws AuthenticationException
     */
    public function checkPrivilege(int $demandLevel, string $token = null): void
    {
        if($token===null || empty($token)) {
            throw new AuthenticationException('Missing authentication token');
        }
        if(!isset($this->activeUsers[$token])) {
            throw new AuthenticationException('Not Authenticated');
        }
        $this->activeUsers[$token]->setLaagCount(0);
    }

    /**
     * Update laag
     */
    public function tick()
    {
        /** @var ActiveUser $activeUser */
        foreach ($this->activeUsers as $token => $activeUser) {
            if($activeUser->getLaagCount() >= 60) {
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

        $token = md5($this->appSalt . '-' . md5($userUuid) . '-' . hrtime(true));
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