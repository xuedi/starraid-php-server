<?php

use App\Service\AuthenticationService;
use App\Service\DatabaseService;
use App\Service\ObjectService;
use App\Service\RoutingService;
use App\Timer\Timer;

require 'vendor/autoload.php';

try {
    echo "Server @ http://127.0.0.1:8080\n";

    $config = 'config/config.json';

    // App
    $appSalt = md5('4fc6eced41f407502b1caca738c08355');
    $appToken = md5($appSalt.'-'.time());
    $timers = Timer::getInstance();
    $router = new RoutingService();
    $auth = AuthenticationService::getInstance($appToken);
    $database = DatabaseService::getInstance($config);
    $objects = ObjectService::getInstance();
    $objects->init($database); // load $ set database


    // Server
    $loop = React\EventLoop\Factory::create();
    $socket = new React\Socket\Server(8080, $loop);
    $server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($router) {
        return $router->dispatch($request);
    });
    $server->listen($socket);


    // Timer
    $loop->addPeriodicTimer(1, [$auth, 'tick']);


    // Start
    $loop->run();

} catch (Exception $e) {
    echo "##### The App had an 500-Error #####\n" . $e->getMessage();
}

/**
 * Todo: #### List ####
 *  - Async saving back into db once in a while
 *  - Async check for changed objects in DB
 *  - BigLoop for neighbourhood preselect (maybe via DB geo select)
 *  - Auth check on every action per default (keep laag on zero)
 *  - Add profiler for loops & the (still) blocking parts
 *  - Updated for players  with there granted items to see (scanner/jammer)
 */