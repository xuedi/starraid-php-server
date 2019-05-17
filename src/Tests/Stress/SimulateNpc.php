<?php
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

use React\EventLoop\LoopInterface;

require 'vendor/autoload.php';

class Npc
{
    private $client; // after login use for spamming the server
    private $runtime;
    private $authToken;
    private static $instance;

    private function __construct(LoopInterface $loop)
    {
        $this->runtime = 0;
        $this->authToken = null;
        $this->client = new React\HttpClient\Client($loop);
    }

    public static function getInstance(LoopInterface $loop)
    {
        if (!isset(self::$instance)) {
            self::$instance = new Npc($loop);
        }
        return self::$instance;
    }

    public function tick()
    {
        $this->runtime++;
        echo "Tick: " . $this->runtime . PHP_EOL;

        if ($this->authToken === null) {
            $this->authToken = $this->callApi('http://127.0.0.1:8080/login?user=xuedi&pass=12345')['token'] ?? null;
            echo "Authenticated: " . $this->authToken . PHP_EOL;
            return;
        }

        $update = $this->callApi('http://127.0.0.1:8080/status/update?token=' . $this->authToken);
        dump($update);
    }

    private function callApi(string $uri): array
    {
        $response = file_get_contents($uri);
        $data = json_decode($response, true);
        if ($data) {
            return $data;
        }
        return [];
    }
}


$loop = React\EventLoop\Factory::create();
$loop->addPeriodicTimer(
    1,
    function () use (&$loop) {
        Npc::getInstance($loop)->tick();
    }
);
$loop->run();