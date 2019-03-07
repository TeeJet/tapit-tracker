<?php

namespace app\core\db;

use app\core\base\App;

class SelectQuery
{
    private $className = null;
    private $select;
    private $table;
    private $condition;
    private $params = [];
    private $limit;
    private $order;

    public function class(string $className)
    {
        $this->className = $className;
        return $this;
    }

    public function select(array $select)
    {
        $this->select = implode(', ', $select);
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function order(string $order)
    {
        $this->order = $order;
        return $this;
    }

    public function condition(string $condition, array $params = [])
    {
        $this->condition = $condition;
        $this->params = $params;
        return $this;
    }

    public function one()
    {
        $this->limit = 1;
        $rows = App::$db->select($this->prepareSelect(), $this->params, $this->className);
        if (count($rows) > 0) {
            return $rows[0];
        }
        return null;
    }

    public function all()
    {
        return App::$db->select($this->prepareSelect(), $this->params, $this->className);
    }

    private function prepareSelect()
    {
        $this->select = $this->select ?? "*";
        $sql = "SELECT {$this->select} FROM {$this->table}";
        if ($this->condition) {
            $sql .= " WHERE {$this->condition}";
        }
        if ($this->order) {
            $sql .= " ORDER BY {$this->order}";
        }
        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }
}