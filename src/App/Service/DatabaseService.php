<?php

namespace App\Service;

use App\ValueObjects\DatabaseConfig;
use Exception;
use PDO;
use PDOException;

class DatabaseService
{
    /** @var PDO null */
    private $initTime;

    /** @var PDO null */
    private $pdo;

    /**
     * DatabaseService constructor.
     * @param DatabaseConfig $config
     * @throws Exception
     */
    public function __construct(DatabaseConfig $config)
    {
        $this->pdo = null;
        $this->initTime = null;
        $this->connect($config);
    }

    /**
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

    /**
     * @param DatabaseConfig $config
     * @throws Exception
     */
    private function connect(DatabaseConfig $config)
    {
        $this->initTime = time();
        $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"];

        try {
            $this->pdo = new PDO($config->getDsn(), $config->getUser(), $config->getPass(), $options);
        } catch (PDOException $e) {
            throw new Exception("DatabaseService::init(): Could not connect to DB: " . $e->getMessage());
        }
    }
}