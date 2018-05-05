<?php

namespace App\Service;

class ObjectService
{
    /** array */
    private $objects;
    private static $instance;

    private function __construct()
    {
        $this->objects = [];
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ObjectService();
        }

        return self::$instance;
    }

    public function add($var)
    {
        $this->objects[] = $var;
    }

    public function loadSave()
    {
        //
    }

    public function getStatus(): array
    {
        return [
            'Objects' => count($this->objects),
        ];
    }
}