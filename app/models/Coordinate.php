<?php

namespace app\models;


use app\core\db\Model;

/**
 * Class Coordinate
 *
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property int $device_id
 * @property int $created_at
 */
class Coordinate extends Model
{
    private $timeout = 60 * 60;

    public static function table()
    {
        return "coordinates";
    }

    public static function fields()
    {
        return ['id', 'lat', 'lng', 'device_id', 'created_at'];
    }

    public function save()
    {
        if (empty($this->id)) {
            $this->created_at = time();
        }
        return parent::save();
    }

    public function nmea2degree($coordinate)
    {
        $coordinate /= 100;
        return (int)$coordinate + ($coordinate - (int)$coordinate) / 60 * 100;
    }

    public function getIconColor()
    {
        return $this->created_at + $this->timeout < time() ? "darkred" : "darkgreen";
    }
}