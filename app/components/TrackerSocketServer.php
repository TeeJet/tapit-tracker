<?php

namespace app\components;

use app\core\server\SocketServer;
use app\models\Coordinate;
use app\models\Device;

class TrackerSocketServer extends SocketServer
{
    public function __construct($config)
    {
        $server = $config['server'];
        $port = $config['port'];
        parent::__construct($server, $port);
    }

    protected function handleMessage($client, $message)
    {
        $data = explode("#", $message);
        if (!$device = Device::findOne("name = :name", [':name' => $data[1]])) {
            $device = new Device();
            $device->name = $data[1];
            $device->save();
        }

        $nmea = explode(',', $data[6]);
        $coordinate = new Coordinate();
        $coordinate->device_id = $device->id;
        $coordinate->lat = $coordinate->nmea2degree($nmea[3]);
        $coordinate->lng = $coordinate->nmea2degree($nmea[5]);
        $coordinate->save();
    }
}