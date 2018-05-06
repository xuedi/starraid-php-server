<?php

namespace App\Service;

use App\Entities\Authentication;
use App\Entities\Interfaces\Database;
use App\Entities\SpaceshipEntity;
use App\Entities\UserEntity;
use DateTime;

/**
 * Class ObjectService
 * @package App\Service
 */
class ObjectService
{
    const ENTITIES = [
        'user' => UserEntity::class,
        'spaceship' => SpaceshipEntity::class,
    ];

    private $objects;

    /** @var string */
    private $appToken;

    /** @var Authentication */
    private $auth;

    /** @var DatabaseService */
    private $database;

    /** @var ObjectService */
    private static $instance;

    /**
     * ObjectService constructor.
     */
    private function __construct()
    {
        $this->auth = [];
        $this->appToken = null;
        $this->database = DatabaseService::getInstance();
        foreach (self::ENTITIES as $key => $entityClass) {
            $this->objects[$key] = [];
        }
    }

    /**
     * @return ObjectService
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ObjectService();
        }

        return self::$instance;
    }

    /**
     * Loads all data from DB
     * @param string $appToken
     */
    public function load(string $appToken)
    {
        /** @var Database $entity */
        foreach (self::ENTITIES as $tableName => $entityClassName) {
            $dataRows = $this->database->select('SELECT * FROM ' . $tableName);
            foreach ($dataRows as $dataRow) {
                $entity = new $entityClassName();
                $entity->map($dataRow);
                $this->objects[$tableName][$entity->getUuid()] = $entity;
                unset($entity);
            }
        }
        $this->appToken = $appToken;
        //dump($this->objects);
    }

    /**
     * @return array
     */
    public function getStatus(): array
    {
        $status = [];
        foreach (self::ENTITIES as $key => $entityClass) {
            $status[$key] = count($this->objects[$key]);
        }
        return $status;
    }

    /**
     * @param string $user
     * @param string $pass
     * @return array
     */
    public function authenticate(string $user, string $pass): array
    {
        /** @var UserEntity $userEntity */
        foreach ($this->objects['user'] as $key => $userEntity) {
            if ($userEntity->getName() == $user && $userEntity->getPassword() == $pass) {
                $token = md5($this->appToken . '-' . md5($user) . '-' . rand(0, 10000));
                $auth = new Authentication();
                $auth->setLoginAt(new DateTime());
                $auth->setUserUuid($userEntity->getUuid());
                $this->objects[$token] = $auth;
                dump("AuthSuccess: Token=$token, User=$user");

                return [
                    'success' => true,
                    'token' => $token,
                ];
            }
        }
        return [
            'success' => false,
        ];
    }
}