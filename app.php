<?php

use App\Service\AuthenticationService;
use App\Service\DatabaseService;
use App\Service\ObjectService;
use App\Service\RoutingService;
use App\Timer\Timer;
use App\ValueObjects\Config;

require 'vendor/autoload.php';

try {

    // App
    $config = Config::from('config/config.json');
    $auth = new AuthenticationService($config->getAppToken());
    $database = new DatabaseService($config->getDatabaseConfig());
    $router = new RoutingService();
    $timers = new Timer();

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
 */