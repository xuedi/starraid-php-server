<?php

namespace App\Service;

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
        LoginController::class,
        StatusController::class,
        ObjectController::class,
    ];

    /**
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    public function dispatch(ServerRequestInterface $request): Response
    {
        // prepare data
        $path = trim($request->getUri()->getPath(), '/');
        if (empty($path)) {
            return $this->error(404, 'No controller requested');
        }

        // split data
        list($controller, $method) = explode('/', $path);
        if (empty($method)) {
            $method = 'index';
        }

        // fire up controller
        $controllerClassName = $this->findController($controller);
        if(empty($controllerClassName)) {
            return $this->error(404, "The requested controller was not found");
        }

        // call method
        $controllerClass = call_user_func([$controllerClassName, 'getInstance']);
        if (!method_exists($controllerClass, $method)) {
            return $this->error(500, 'The requested method does not exist');
        }

        return $controllerClass->{$method}($request);
    }

    /**
     * @param string $controller
     * @return string
     * @throws Exception
     */
    private function findController(string $controller): ?string
    {
        $requestedController = strtolower('App\Controller\\' . $controller . 'Controller');
        foreach (self::CONTROLLER as $className) {
            if (strtolower($className) == $requestedController) {
                return $className;
            }
        }
        return null;
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