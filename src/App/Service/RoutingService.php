<?php

namespace App\Service;

use App\Controller\AdminController;
use App\Controller\DefaultController;
use App\Controller\LoginController;
use App\Controller\ObjectController;
use App\Controller\StatusController;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * Class RoutingService
 * @package App\Service
 */
class RoutingService
{
    const CONTROLLER = [
        'login' => LoginController::class,
        'status' => StatusController::class,
        'object' => ObjectController::class,
        'admin' => AdminController::class,
        'default' => DefaultController::class,
    ];

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    public function dispatch(ServerRequestInterface $request): Response
    {
        echo "[" . $request->getMethod() . "] " . $request->getUri() . "\n";
        try {
            list($controller, $methodName) = $this->prepareParameter($request->getUri()->getPath());
            $controllerName = $this->getControllerName($controller);

            return $this->executeMethod($controllerName, $methodName, $request);
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    /**
     * @param string $uriPath
     * @return array
     * @throws Exception
     */
    private function prepareParameter(string $uriPath): array
    {
        $path = trim($uriPath, '/');
        if (!empty($path)) {
            list($controller, $method) = array_pad(explode('/', $path, 2), 2, null);
        }

        return [
            $controller ?? self::CONTROLLER['default'],
            $method ?? 'index',
        ];
    }

    /**
     * @param string $controller
     * @return string
     * @throws Exception
     */
    private function getControllerName(string $controller): string
    {
        $controller = strtolower($controller);
        if (!isset(self::CONTROLLER[$controller])) {
            return self::CONTROLLER['default'];
        }

        return self::CONTROLLER[$controller];
    }

    /**
     * @param string $className
     * @param string $method
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    private function executeMethod(string $className, string $method, ServerRequestInterface $request): Response
    {
        $controllerClass = call_user_func([$className, 'getInstance']);
        if (!method_exists($controllerClass, $method)) {
            throw new Exception('The requested method does not exist');
        }

        return $controllerClass->{$method}($request);
    }

    /**
     * @param int $errorCode
     * @param string $message
     * @return Response
     */
    private function error(int $errorCode, string $message): Response
    {
        return new Response($errorCode, ['Content-Type' => 'text/plain'], $message);
    }
}