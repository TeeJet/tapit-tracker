<?php

namespace app\models;

use app\core\db\Model;

/**
 * Class Device
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 */
class Device extends Model
{
    public static function table()
    {
        return "devices";
    }

    public static function fields()
    {
        return ['id', 'name', 'created_at'];
    }

    public function save()
    {
        if (empty($this->id)) {
            $this->created_at = time();
        }
        return parent::save();
    }

    /**
     * @return Coordinate
     */
    public function getLastCoordinate()
    {
        return Coordinate::findOne("device_id = :device", [":device" => $this->id], ["order" => "created_at DESC"]);
    }
}