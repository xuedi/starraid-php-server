<?php

namespace App\Service;

use App\Controller\AdminController;
use App\Controller\DefaultController;
use App\Controller\Interfaces\Routable;
use App\Controller\LoginController;
use App\Controller\ObjectController;
use App\Controller\StatusController;
use Exception;
use Pimple\Container;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class RoutingService
 * @package App\Service
 */
class RoutingService
{
    const CONTROLLER_MAP = [
        'login' => LoginController::class,
        'status' => StatusController::class,
        'object' => ObjectController::class,
        'admin' => AdminController::class,
        'default' => DefaultController::class,
    ];

    /** @var Container */
    private $ctn;

    /**
     * RoutingService constructor.
     * @param Container $ctn
     */
    public function __construct(Container $ctn)
    {
        $this->ctn = $ctn;
    }

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
            $controller ?? self::CONTROLLER_MAP['default'],
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
        if (!isset(self::CONTROLLER_MAP[$controller])) {
            return self::CONTROLLER_MAP['default'];
        }

        return self::CONTROLLER_MAP[$controller];
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
        $controllerClass = null;
        if(!class_exists($className)) {
            throw new Exception('The requested controller does not exist');
        }

        $constructor = (new ReflectionClass($className))->getConstructor();
        if ($constructor === null) { // no parameter in constructor
            $controllerClass = new $className();
        } else {
            $parameters = [];
            /** @var ReflectionParameter $parameter */
            foreach ($constructor->getParameters() as $parameter) {
                $parameterClassName = $parameter->getType()->getName();
                $parameters[] = $this->ctn[$parameterClassName];
            }
            $controllerClass =  call_user_func_array(array($controllerClass, '__construct'), $parameters);
        }

        if(!$controllerClass instanceof Routable) {
            throw new Exception('The requested controller is not routable');
        }

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