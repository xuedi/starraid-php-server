<?php

namespace App\Controller;

use App\Controller\Interfaces\Routable;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class Object
 * @package App\Controller
 */
class Object implements Routable
{
    /**
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function index(ServerRequestInterface $request): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], "App: 0.3\n");
    }
}