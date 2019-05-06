<?php

require '../../vendor/autoload.php';

$loop = React\EventLoop\Factory::create();
$client = new React\HttpClient\Client($loop);

$request = $client->request('GET', 'https://github.com/');
$request->on('response', function ($response) {
    $response->on('data', function ($chunk) {
        echo $chunk;
    });
    $response->on('end', function() {
        echo 'DONE';
    });
});
$request->on('error', function (\Exception $e) {
    echo $e;
});
$request->end();
$loop->run();