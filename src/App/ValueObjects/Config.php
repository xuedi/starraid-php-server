<?php

namespace App\ValueObjects;

use Exception;
use PDO;
use PDOException;

/**
 * Class Config
 * @package App\ValueObjects
 */
class Config
{
    /** @var string */
    private $appSalt;

    /** @var string */
    private $appToken;

    /** @var DatabaseConfig */
    private $databaseConfig;

    /**
     * @param string $configFile
     * @return Config
     * @throws Exception
     */
    public static function from(string $configFile)
    {
        return new self($configFile);
    }

    /**
     * Config constructor.
     * @param string $configFile
     * @throws Exception
     */
    private function __construct(string $configFile)
    {
        $config = $this->loadConfig($configFile);
        $this->ensureAppSalt($config['appSalt']);
        $this->ensureAppToken($config['appSalt']);
        $this->databaseConfig = DatabaseConfig::from(
            $config['database']['host'] ?? '127.0.0.1',
            $config['database']['port'] ?? 3306,
            $config['database']['user'],
            $config['database']['pass'],
            $config['database']['name'],
            );
    }

    /**
     * @param string $appSalt
     * @throws Exception
     */
    private function ensureAppSalt(string $appSalt): void
    {
        if (strlen($appSalt) < 32) {
            throw new Exception("The config option 'appSalt' is not valid: '{$appSalt}'");
        }
        $this->appSalt = $appSalt;
    }

    /**
     * @param string $appSalt
     * @throws Exception
     */
    private function ensureAppToken(string $appSalt): void
    {
        if (strlen($appSalt) < 32) {
            throw new Exception("The config option 'appSalt' is not valid: '{$appSalt}'");
        }
        $this->appToken = md5($appSalt.'-'.time());;
    }

    /**
     * @param string $configFile
     * @return array
     * @throws Exception
     */
    private function loadConfig(string $configFile): array
    {
        if (!file_exists($configFile)) {
            throw new Exception('Could not find config file: ' . $configFile);
        }

        $data = json_decode(file_get_contents($configFile), true);
        if (!isset($data)) {
            throw new Exception('Could not load config from file: ' . $configFile);
        }

        return $data;
    }

    //  #####################################################################

    public function getAppSalt(): string
    {
        return $this->appSalt;
    }

    public function getAppToken(): string
    {
        return $this->appToken;
    }

    public function getDatabaseConfig(): DatabaseConfig
    {
        return $this->databaseConfig;
    }
}