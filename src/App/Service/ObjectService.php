<?php

namespace App\Service;

use App\Entities\Interfaces\Database;
use App\Entities\SpaceshipEntity;
use App\Entities\UserEntity;

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

    /** @var DatabaseService */
    private $database;

    /** @var ObjectService */
    private static $instance;

    /**
     * ObjectService constructor.
     */
    private function __construct()
    {
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
     */
    public function load()
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
     * @param string|null $group
     * @return array
     */
    public function getObjects(string $group = null): array
    {
        if (!empty($group)) {
            return $this->objects[$group];
        }
        return $this->objects[$group];
    }
}