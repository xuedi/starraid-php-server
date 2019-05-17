<?php

namespace App\Service;

use App\Controller\AdminController;
use App\Controller\DefaultController;
use App\Controller\Interfaces\Routable;
use App\Controller\AuthenticationController;
use App\Controller\EntityController;
use App\Controller\StatusController;
use App\ValueObjects\Config;
use Pimple\Container;
use ReflectionClass;
use ReflectionException;

class ContainerService
{
    const CONTROLLER = [
        AuthenticationController::class,
        AdminController::class,
        StatusController::class,
        EntityController::class,
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

        $ctn[EntityService::class] = function ($ctn) {
            return new EntityService($ctn[DatabaseService::class]);
        };

        $ctn[AuthenticationService::class] = function ($ctn) {
            return new AuthenticationService($ctn[EntityService::class], $ctn[Config::class]->getAppToken());
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