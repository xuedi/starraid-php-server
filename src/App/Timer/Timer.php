<?php

namespace App\Timer;

use App\Service\EntityService;
use Exception;

class Timer
{

    /** ObjectService */
    private $objects = null;

    /** int */
    private $ticks = null;

    /**
     * Timer constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->ticks = 0;
        $this->objects = EntityService::getInstance();
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
        dump(
            [
                'Ticks' => $this->ticks,
                'Objects' => $this->objects->getStatus(),
            ]
        );
    }
}