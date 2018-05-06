<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class TimerController
 * @package App\Controller
 */
class TimerController implements Routable
{

    /** ObjectService */
    private $objects = null;

    /** int */
    private $ticks = null;


    /**
     * TimerController constructor.
     */
    public function __construct()
    {
        $this->ticks = 0;
        $this->objects = \App\Service\ObjectService::getInstance();
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], "App: 0.3\n");
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