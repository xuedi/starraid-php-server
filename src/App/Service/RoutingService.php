<?php

namespace App\Service;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class RoutingService
{
    public function __construct()
    {
        //
    }

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    public function dispatch(ServerRequestInterface $request): Response
    {
        $path = trim($request->getUri()->getPath(), '/');
        if (empty($path)) {
            $this->createResponse('Version: 0.1');
        }

        list($controller, $method) = explode('/', $path);
        if (empty($method)) {
            $method = 'index';
        }


        dump('Controller: ' . $controller . ', Method: ' . $method);

        throw new Exception('Could not dispatch to any controller');
    }

    private function createResponse(string $message): Response
    {
        return new Response(200, ['Content-Type' => 'text/plain'], $message . "\n");
    }
}