<?php

require 'vendor/autoload.php';

// App
$timer = new App\Controller\TimerController();
$router = new App\Service\RoutingService();
$objects = \App\Service\ObjectService::getInstance();
$objects->add('test');

// Server
$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server(8080, $loop);
$server = new React\Http\Server(function (Psr\Http\Message\ServerRequestInterface $request) use ($router) {
    return $router->dispatch($request);
});
$server->listen($socket);

// Timer
$loop->addPeriodicTimer(1, [$timer, 'updateObjects']);
$loop->addPeriodicTimer(5, [$timer, 'statusDump']);

// Start
echo "Server running at http://127.0.0.1:8080\n";
$loop->run();

/*


use React\MySQL\Connection;

try {
    $connection = new Connection($loop, [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'passwd' => '',
        'dbname' => 'starraid',
    ]);
    $connection->connect(function (?Exception $error, $connection) {
        if ($error) {
            echo 'Connection failed: ' . $error->getMessage() . "\n";
        } else {
            echo 'Successfully connected';
        }
    });
} catch (\React\MySQL\Exception $e) {
    echo "Database problem " . $e->getMessage() . "\n";
}


try {
    $connection->query('select * from login', function ($command, $connection) use ($loop) {
        if ($command->hasError()) { //test whether the query was executed successfully
            //error
            $error = $command->getError();// get the error object, instance of Exception.
        } else {
            $results = $command->resultRows; //get the results
            $fields = $command->resultFields; // get table fields
        }
        $loop->stop(); //stop the main loop.
    });
} catch (\React\MySQL\Exception $e) {
    echo "Database problem " . $e->getMessage() . "\n";
}


$loop->addPeriodicTimer(1, function () use (&$i) {
    echo "big loop\n";
});

$loop->addPeriodicTimer(10, function () use (&$i) {
    echo "sync changed to DB\n";
});
*/

