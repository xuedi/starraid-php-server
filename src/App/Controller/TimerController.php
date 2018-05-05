<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class TimerController implements Routable
{
    /** ObjectService */
    private $objects = null;

    public function __construct()
    {
        $this->objects = \App\Service\ObjectService::getInstance();
    }

    public function index(ServerRequestInterface $request): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], "App: 0.3\n");
    }

    public function updateObjects()
    {
        //echo "updateObjects\n";
        $this->objects->add('updateObjects');
    }

    public function statusDump()
    {
        dump([
            'ObjectService' => $this->objects->getStatus(),
        ]);
    }
}