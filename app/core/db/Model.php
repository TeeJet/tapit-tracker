<?php

namespace app\core\db;

use app\core\base\App;

abstract class Model
{
    private $primaryKey = "id";

    abstract public static function table();

    abstract public static function fields();

    /**
     * @param string $condition
     * @param array $params
     * @param array $options
     * @return static[]
     */
    public static function findAll($condition = "", $params = [], $options = [])
    {
        $query = self::prepareSelect();
        if ($condition) {
            $query->condition($condition, $params);
        }
        if (isset($options['order'])) {
            $query->order($options['order']);
        }
        return $query->all();
    }

    /**
     * @param string $condition
     * @param array $params
     * @param array $options
     * @return static
     */
    public static function findOne($condition = "", $params = [], $options = [])
    {
        $query = self::prepareSelect();
        if ($condition) {
            $query->condition($condition, $params);
        }
        if (isset($options['order'])) {
            $query->order($options['order']);
        }
        return $query->one();
    }

    public function save()
    {
        $query = new ExecuteQuery();
        $query->table(static::table());
        if (!empty($this->{$this->primaryKey})) {
            $query->method("UPDATE");
            $query->condition("id = :id", [':id' => $this->{$this->primaryKey}]);
        } else {
            $query->method("INSERT");
        }
        $fields = get_object_vars($this);
        foreach ($fields as $name => $value) {
            if (!in_array($name, static::fields())) {
                unset($fields[$name]);
            }
        }
        $query->fields($fields);
        $result = $query->execute();
        if (empty($this->{$this->primaryKey})) {
            $this->{$this->primaryKey} = App::$db->getLastInsertId();
        }

        return $result;
    }

    private static function prepareSelect()
    {
        $query = new SelectQuery();
        $query->class(static::class);
        $query->table(static::table());
        return $query;
    }
}