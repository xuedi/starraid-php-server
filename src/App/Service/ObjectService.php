<?php

namespace App\Service;

use App\Entities\Interfaces\Database;
use App\Entities\RoleEntity;
use App\Entities\SpaceshipEntity;
use App\Entities\UserEntity;
use App\Entities\UserRoleEntity;


/**
 * Class ObjectService
 * @package App\Service
 */
class ObjectService
{
    //TODO: make dynamic dependencies
    const ENTITIES = [
        'role' => RoleEntity::class,
        'user_role' => UserRoleEntity::class,
        'user' => UserEntity::class, // depend on [role, user_role]
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
    public function loadAllDB()
    {
        /** @var Database $entity */
        /** @var Database $entityToUpdate */

        // map all entities
        foreach (self::ENTITIES as $tableName => $entityClassName) {
            $dataRows = $this->database->select('SELECT * FROM ' . $tableName);
            foreach ($dataRows as $dataRow) {
                $entity = new $entityClassName();
                $entity->load($dataRow);
                $this->objects[$tableName][$entity->getUuid()] = $entity;
                unset($entity);
            }
        }

        // map sub entities when they have a relationship
        foreach (self::ENTITIES as $tableName => $entityClassName) {
            $mapList = (new $entityClassName())->{'mapping'}();
            if (empty($mapList)) {
                continue;
            }
            foreach ($this->objects[$tableName] as $entityToUpdate) {

                $searchIds = [];
                $searchIds[] = $entityToUpdate->getUuid();
                foreach ($mapList as $targetSetter => $steps) {
                    foreach ($steps as $step) {
                        $searchIds = $this->search($searchIds, $step);
                    }

                    $entityList = [];
                    $lastTable = end($steps)['table'];
                    foreach ($searchIds as $id) {
                        $entityList[] = $this->objects[$lastTable][$id];
                    }
                    if (method_exists($entityToUpdate, $targetSetter)) {
                        $this->objects[$tableName][$entityToUpdate->getUuid()]->{$targetSetter}($entityList);
                    }
                }
            }

        }
    }

    /**
     * @param array $searchIds
     * @param array $map
     * @return array
     */
    private function search(array $searchIds = [], array $map): array
    {
        $newSearchIds = [];
        /** @var Database $entity */
        foreach ($this->objects[$map['table']] as $entity) {
            foreach ($searchIds as $searchId) {
                if (!method_exists($entity, $map['getterFindBy']) || !method_exists($entity, $map['getterSearch'])) {
                    continue;
                }
                if ($entity->{$map['getterFindBy']}() == $searchId) {
                    $newSearchIds[] = $entity->{$map['getterSearch']}();
                }
            }
        }
        return $newSearchIds;
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
            return $this->objects[$group] ?? [];
        }
        return $this->objects;
    }
}