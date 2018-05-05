<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class Object implements Routable
{
    public function index(ServerRequestInterface $request): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], "App: 0.3\n");
    }

    public function getLocation()
    {
        //
    }
}