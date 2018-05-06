<?php

namespace App\Service;

use Exception;
use LessQL\Database;
use PDO;
use PDOException;

/**
 * //TODO: Use non-blocking: https://github.com/friends-of-reactphp/mysql
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

    /** @var Database null */
    private $db;

    /** @var DatabaseService */
    private static $instance;

    /**
     * DatabaseService constructor.
     */
    private function __construct()
    {
        $this->pdo = null;
        $this->db = null;
        $this->initTime = null;
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
        $this->initTime = time();
        array_walk($configData, [$this, 'validateOptions']);

        $dsn = "mysql:host={$configData['host']};port={$configData['port']};dbname={$configData['name']}";
        $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"];
        try {
            $this->pdo = new PDO($dsn, $configData['user'], $configData['pass'], $options);
        } catch (PDOException $e) {
            throw new Exception("DatabaseService::init(): Could not connect to DB: " . $e->getMessage());
        }
        $this->db = new Database($this->pdo);
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