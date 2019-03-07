<?php

namespace app\core\db;

use PDO;

class PgSql implements Database
{
    /** @var PDO */
    public $pdo;

    private $driver = "pgsql";
    private $host;
    private $user;
    private $pass;
    private $dbName;

    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->dbName = $config['dbName'];

        $this->connect();
    }

    public function connect()
    {
       $this->pdo = new PDO("{$this->driver}:host={$this->host};dbname={$this->dbName}", $this->user, $this->pass);
    }

    public function select($sql, $params = [], $className = null)
    {
        $stmt = $this->execute($sql, $params);
        if ($className) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, $className);
        }
        $result = [];
        while ($row = $stmt->fetch()) {
            $result[] = $row;
        }
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        $errors = $stmt->errorInfo();
        return empty($errors[2]);
    }

    /**
     * @param $sql
     * @param $params
     * @return bool|\PDOStatement
     */
    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $this->checkParams($params);
        $stmt->execute($params);
        return $stmt;
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    private function checkParams(array &$params)
    {
        foreach ($params as &$param) {
            $param = htmlentities($param);
        }
    }
}