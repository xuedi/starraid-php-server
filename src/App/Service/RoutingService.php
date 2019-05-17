<?php

namespace App\Service;

use App\Controller\Interfaces\Routable;
use App\Exceptions\AuthenticationException;
use Exception;
use Pimple\Container;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

class RoutingService
{
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
     */
    public function dispatch(ServerRequestInterface $request): Response
    {
        echo '[' . $request->getMethod() . '] ' . $request->getUri();
        try {
            $path = trim($request->getUri()->getPath(), '/');
            $list = explode('/', $path, 2);
            $list = array_pad($list, 2, null);
            $controller = $list[0] ?? 'default';
            $methodName = $list[1] ?? 'index';
            $controllerClass = "App\Controller\\" . ucfirst(strtolower($controller)) . 'Controller';

            return $this->execute($controllerClass, $methodName, $request);
        } catch (AuthenticationException $e) {
            return $this->error(401, $e->getMessage());
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    /**
     * @param string $className
     * @param string $method
     * @param ServerRequestInterface $request
     * @return Response
     * @throws Exception
     */
    private function execute(string $className, string $method, ServerRequestInterface $request): Response
    {
        if (!$this->ctn->offsetExists($className)) {
            return $this->error(404, 'The requested controller does not exist');
        }

        $controllerClass = $this->ctn[$className];
        if (!$controllerClass instanceof Routable) {
            return $this->error(404, 'The requested controller not routable');
        }

        if (!method_exists($controllerClass, $method)) {
            return $this->error(404, 'The requested method does not exist');
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
        echo ' [' . $errorCode . ']' . PHP_EOL;
        return new Response($errorCode, ['Content-Type' => 'text/plain'], $message);
    }
}
