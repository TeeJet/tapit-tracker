<?php

namespace app\core\db;

interface Database
{
    public function connect();

    public function select($sql, $params, $className);

    public function query($sql, $params);

    public function execute($sql, $params);

    public function getLastInsertId();
}