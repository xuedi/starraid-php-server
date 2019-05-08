<?php

use App\Service\AuthenticationService;
use App\Service\DatabaseService;
use App\Service\ObjectService;
use App\Service\RoutingService;
use App\ValueObjects\Config;
use Pimple\Container;
use Psr\Http\Message\ServerRequestInterface;

require 'vendor/autoload.php';

try {


    // Pimple
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


    // Server
    $loop = React\EventLoop\Factory::create();
    $router = new RoutingService($ctn); // autoinjects ctn dependencies to controllers
    $socket = new React\Socket\Server(8080, $loop);
    $server = new React\Http\Server(function (ServerRequestInterface $request) use ($router) {
        return $router->dispatch($request); //TODO DI container in there for pass on controllers
    });
    $server->listen($socket);


    // Timer
    $loop->addPeriodicTimer(1, [$ctn[AuthenticationService::class], 'tick']);


    // Debug
    echo "Server @ http://127.0.0.1:8080\n";


    // Start
    $loop->run();

} catch (Exception $e) {
    echo "##### The App had an 500-Error #####\n" . $e->getMessage() . "\n";
}

/**
 * Todo: #### List ####
 *  - Async saving back into db once in a while
 *  - Async check for changed objects in DB
 *  - BigLoop for neighbourhood preselect (maybe via DB geo select)
 *  - Auth check on every action per default (keep laag on zero)
 *  - Add profiler for loops & the (still) blocking parts
 *  - Updated for players  with there granted items to see (scanner/jammer)
 *  - Possible usage of LessQL
 */