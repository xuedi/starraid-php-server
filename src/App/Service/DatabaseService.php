<?php

namespace App\Service;

use Exception;
use PDO;
use PDOException;

/**
 * //TODO: Use non-blocking: https://github.com/friends-of-reactphp/mysql
 * Class DatabaseService
 * @package App\Service
 */
class DatabaseService
{
    const OPTIONS = [
        'host' => FILTER_VALIDATE_IP,
        'name' => null,
        'port' => FILTER_VALIDATE_INT,
        'user' => null,
        'pass' => null,
    ];
    private $pdo;
    private static $instance;

    /**
     * DatabaseService constructor.
     */
    private function __construct()
    {
        $this->pdo = null;
    }

    /**
     * @return DatabaseService
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DatabaseService();
        }
        return self::$instance;
    }

    /**
     * @param array $configData
     * @throws Exception
     */
    public function init(array $configData)
    {
        array_walk($configData, [$this, 'validateOptions']);

        $dsn = "mysql:host={$configData['host']};port={$configData['port']};dbname={$configData['name']}";
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
        try {
            $this->pdo = new PDO($dsn, $configData['user'], $configData['pass'], $options);
        } catch (PDOException $e) {
            throw new Exception("DatabaseService::init(): Could not connect to DB: " . $e->getMessage());
        }
    }

    /**
     * @param $configValue
     * @param $configKey
     * @throws Exception
     */
    private function validateOptions($configValue, $configKey)
    {
        if (!array_key_exists($configKey, self::OPTIONS)) {
            throw new Exception("DatabaseService::init(): Option '$configKey' is not allowed");
        }
        $filterFlag = self::OPTIONS[$configKey];
        if (!empty($filterFlag)) {
            if (filter_var($configValue, $filterFlag) === FALSE) {
                throw new Exception("DatabaseService::init(): Option '$configKey' ('$configValue') is not valid");
            }
        }
    }

    /**
     * @param $var
     */
    public function query($var)
    {
        echo "Query\n";
    }
}