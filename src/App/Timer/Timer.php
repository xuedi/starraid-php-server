<?php

namespace App\Timer;

/**
 * Class Timer
 * @package App\Controller
 */
class Timer
{

    /** ObjectService */
    private $objects = null;

    /** int */
    private $ticks = null;

    /** @var Timer */
    private static $instance;

    /**
     * DatabaseService constructor.
     */
    private function __construct()
    {
        $this->ticks = 0;
        $this->objects = \App\Service\ObjectService::getInstance();
    }

    /**
     * @return Timer
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Timer();
        }
        return self::$instance;
    }

    /**
     *
     */
    public function loadObjects()
    {
        $this->ticks++;
        //dump($this->objects);
        //echo "updateObjects()\n";
        //$this->objects->add('updateObjects');
    }

    /**
     *
     */
    public function statusDump()
    {
        dump([
            'Ticks' => $this->ticks,
            'Objects' => $this->objects->getStatus(),
        ]);
    }
}