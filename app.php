<?php

require 'vendor/autoload.php';

try {


    // App
    $appSalt = md5('4fc6eced41f407502b1caca738c08355');
    $appToken = md5($appSalt.'-'.time());
    $timer = \App\Timer\Timer::getInstance();
    $router = new App\Service\RoutingService();
    $database = \App\Service\DatabaseService::getInstance();
    $database->init([
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'starraid',
        'pass' => '12345',
        'name' => 'starraid',
    ]);
    $objects = \App\Service\ObjectService::getInstance();
    $objects->load($appToken);


    // Server
    $loop = React\EventLoop\Factory::create();
    $socket = new React\Socket\Server(8080, $loop);
    $server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($router) {
        return $router->dispatch($request);
    });
    $server->listen($socket);


    // Timer
    //$loop->addPeriodicTimer(1, [$timer, 'updateObjects']);
    //$loop->addPeriodicTimer(5, [$timer, 'statusDump']);


    // Start
    echo "Server running at http://127.0.0.1:8080\n";
    $loop->run();

} catch (Exception $e) {
    echo "##### The App had an 500-Error #####\n" . $e->getMessage();
}