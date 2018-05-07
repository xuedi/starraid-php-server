<?php

require 'vendor/autoload.php';

try {
    echo "Server @ http://127.0.0.1:8080\n";


    // App
    $appSalt = md5('4fc6eced41f407502b1caca738c08355');
    $appToken = md5($appSalt.'-'.time());
    $timers = \App\Timer\Timer::getInstance();
    $router = new App\Service\RoutingService();
    $database = \App\Service\DatabaseService::getInstance();
    $auth = \App\Service\AuthenticationService::getInstance($appToken);
    $database->init([
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'starraid',
        'pass' => '12345',
        'name' => 'starraid',
    ]);
    $objects = \App\Service\ObjectService::getInstance();
    $objects->loadAllDB();


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