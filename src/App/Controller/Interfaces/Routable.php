<?php

namespace App\Controller\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

interface Routable
{
    public function index(ServerRequestInterface $request): Response;
}