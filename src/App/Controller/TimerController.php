<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class TimerController implements Routable
{
    /** ObjectService */
    private $objects = null;

    /** DatabaseService */
    private $database = null;

    public function __construct()
    {
        $this->objects = \App\Service\ObjectService::getInstance();
        $this->database = \App\Service\DatabaseService::getInstance();
    }

    public function index(ServerRequestInterface $request): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], "App: 0.3\n");
    }

    public function updateObjects()
    {
        dump($this->database);
        //echo "updateObjects()\n";
        //$this->objects->add('updateObjects');
    }

    public function statusDump()
    {
        dump([
            'ObjectService' => $this->objects->getStatus(),
        ]);
    }
}