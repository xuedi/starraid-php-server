<?php

namespace App\Service;

use Exception;
use PDO;
use PDOException;

/**
 * Class DatabaseService
 * @package App\Service
 */
class DatabaseService
{
    /** @var array */
    const OPTIONS = [
        'host' => FILTER_VALIDATE_IP,
        'name' => null,
        'port' => FILTER_VALIDATE_INT,
        'user' => null,
        'pass' => null,
    ];

    /** @var PDO null */
    private $initTime;

    /** @var PDO null */
    private $pdo;

    /** @var array */
    private $config;

    /** @var DatabaseService */
    private static $instance;

    /**
     * DatabaseService constructor.
     * @param string $configFile
     * @throws Exception
     */
    private function __construct(string $configFile)
    {
        $this->pdo = null;
        $this->initTime = null;
        $this->init($configFile);
    }

    /**
     * @param string $configFile
     * @return DatabaseService
     * @throws Exception
     */
    public static function getInstance(string $configFile)
    {
        if (!isset(self::$instance)) {
            self::$instance = new DatabaseService($configFile);
        }
        return self::$instance;
    }

    /**
     * @param string $configFile
     * @throws Exception
     */
    private function init(string $configFile)
    {
        if(!file_exists($configFile)) {
            throw new Exception('Could not find config file: '. $configFile);
        }

        $data = json_decode(file_get_contents($configFile), true);
        if(!isset($data['database'])) {
            throw new Exception('Could not load database settings from config file: '. $configFile);
        }

        $this->initTime = time();
        array_walk($data['database'], [$this, 'validateOptions']);

        $dsn = "mysql:host={$data['database']['host']};port={$data['database']['port']};dbname={$data['database']['name']}";
        $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"];
        try {
            $this->pdo = new PDO($dsn, $data['database']['user'], $data['database']['pass'], $options);
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
            if (filter_var($configValue, $filterFlag) === false) {
                throw new Exception("DatabaseService::init(): Option '$configKey' ('$configValue') is not valid");
            }
        }
    }

    /**
     * TODO: Use LessQL
     * @param $sql
     * @param array $parameter
     * @param int $fetchMode
     * @return array
     */
    public function select($sql, $parameter = [], $fetchMode = PDO::FETCH_ASSOC)
    {
        if (empty($this->pdo)) {
            return [];
        }
        $sth = $this->pdo->prepare($sql);
        if (isset($parameter)) {
            foreach ($parameter as $key => $value) {
                $sth->bindValue("$key", $value);
            }
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }
}