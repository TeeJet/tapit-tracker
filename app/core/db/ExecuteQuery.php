<?php

namespace app\core\db;

use app\core\base\App;

class ExecuteQuery
{
    private $table;
    private $method;
    private $condition;
    private $params = [];
    private $fields;
    private $paramCounter = 0;

    public function method(string $method)
    {
        if (!in_array(strtoupper($method), ['INSERT', 'UPDATE', 'DELETE'])) {
            throw new \InvalidArgumentException('Method must be "insert", "delete" or "update"');
        }
        $this->method = $method;
        return $this;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function condition(string $condition, array $params = [])
    {
        $this->condition = $condition;
        $this->params = $params;
        return $this;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function execute()
    {
        $sql = $this->method;
        switch ($this->method) {
            case "INSERT":
                $sql .= $this->prepareInsert();
                break;
            case "UPDATE":
                $sql .= $this->prepareUpdate();
                break;
            case "DELETE":
                $sql .= $this->prepareDelete();
                break;
        }

        if (!empty($this->condition)) {
            $sql .= " WHERE {$this->condition}";
        }

        return App::$db->query($sql, $this->params);
    }

    private function prepareInsert()
    {
        $sql = " INTO {$this->table} (";
        $sql .= implode(", ", array_keys($this->fields));
        $sql .= ") VALUES (";
        $comma = "";
        foreach ($this->fields as $key => $field) {
            $this->params[":field{$this->paramCounter}"] = $field;
            $sql .= "{$comma} :field{$this->paramCounter}";
            $comma = ",";
            $this->paramCounter++;
        }
        $sql .= ")";
        return $sql;
    }

    private function prepareUpdate()
    {
        $sql = " {$this->table} SET";
        $comma = "";
        foreach ($this->fields as $key => $field) {
            $this->params[":field{$this->paramCounter}"] = $field;
            $sql .= "{$comma} {$key} = :field{$this->paramCounter}";
            $comma = ",";
            $this->paramCounter++;
        }
        return $sql;
    }

    private function prepareDelete()
    {
        return " FROM {$this->table}";
    }
}