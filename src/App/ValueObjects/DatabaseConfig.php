<?php

namespace App\ValueObjects;

use Exception;

class DatabaseConfig
{
    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /** @var string */
    private $user;

    /** @var string */
    private $pass;

    /** @var string */
    private $name;

    /**
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $pass
     * @param string $name
     * @return DatabaseConfig
     * @throws Exception
     */
    public static function from(string $host, int $port, string $user, string $pass, string $name): DatabaseConfig
    {
        return new self($host, $port, $user, $pass, $name);
    }

    /**
     * DatabaseConfig constructor.
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $pass
     * @param string $name
     * @throws Exception
     */
    private function __construct(string $host, int $port, string $user, string $pass, string $name)
    {
        $this->ensureHost($host);
        $this->host = $host;

        $this->ensurePort($port);
        $this->port = $port;

        $this->user = $user;
        $this->pass = $pass;
        $this->name = $name;
    }

    /**
     * @param string $host
     * @throws Exception
     */
    private function ensureHost(string $host): void
    {
        if (filter_var($host, FILTER_VALIDATE_IP) === false) {
            throw new Exception("The config option 'Database:Host' is not valid: '{$host}'");
        }
    }

    /**
     * @param int $port
     * @throws Exception
     */
    private function ensurePort(int $port): void
    {
        if (filter_var($port, FILTER_VALIDATE_INT) === false) {
            throw new Exception("The config option 'Database:Port' is not valid: '{$port}'");
        }
    }

    //  #####################################################################

    public function getDsn(): string
    {
        return "mysql:host={$this->host};port={$this->port};dbname={$this->name}";
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }
}