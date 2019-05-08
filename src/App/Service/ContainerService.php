<?php

namespace App\Service;

use App\Controller\AdminController;
use App\Controller\DefaultController;
use App\Controller\Interfaces\Routable;
use App\Controller\LoginController;
use App\Controller\ObjectController;
use App\Controller\StatusController;
use App\ValueObjects\Config;
use Pimple\Container;
use ReflectionClass;
use ReflectionException;

/**
 * Class ContainerService
 * @package App\Service
 */
class ContainerService
{
    const CONTROLLER = [
        LoginController::class,
        StatusController::class,
        ObjectController::class,
        AdminController::class,
        DefaultController::class,
    ];

    /**
     * @return Container
     * @throws ReflectionException
     */
    public function build(): Container
    {
        $ctn = new Container();

        $ctn[Config::class] = function () {
            return Config::from('config/config.json');
        };

        $ctn[DatabaseService::class] = function ($ctn) {
            return new DatabaseService($ctn[Config::class]->getDatabaseConfig());
        };

        $ctn[ObjectService::class] = function ($ctn) {
            return new ObjectService($ctn[DatabaseService::class]);
        };

        $ctn[AuthenticationService::class] = function ($ctn) {
            return new AuthenticationService($ctn[ObjectService::class], $ctn[Config::class]->getAppToken());
        };

        foreach (self::CONTROLLER as $controllerClass) {
            $controller = $this->getController($ctn, $controllerClass);
            $ctn[$controllerClass] = function () use ($controller) {
                return $controller;
            };
        }

        return $ctn;
    }

    /**
     * @param Container $ctn
     * @param string $className
     * @return Routable
     * @throws ReflectionException
     */
    private function getController(Container $ctn, string $className): Routable
    {
        $refClass = new ReflectionClass($className);
        if ($refClass->getConstructor() === null) {
            return new $className();
        }

        $parameters = [];
        foreach ($refClass->getConstructor()->getParameters() as $parameter) {
            $parameters[] = $ctn[$parameter->getType()->getName()];
        }

        /** @var Routable $controllerClass */
        $controllerClass = $refClass->newInstanceArgs($parameters);

        return $controllerClass;
    }
}