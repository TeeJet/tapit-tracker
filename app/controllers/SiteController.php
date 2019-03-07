<?php

namespace app\controllers;

use app\core\server\Controller;
use app\models\Coordinate;
use app\models\Device;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionCoordinates()
    {
        $devices = Device::findAll();
        $json['type'] = 'FeatureCollection';
        foreach ($devices as $device) {
            /** @var Coordinate $coordinate */
            $coordinate = $device->getLastCoordinate();
            if (empty($coordinate)) {
                continue;
            }
            $json['features'][] = [
                'type' => 'Feature',
                'id' => uniqid(),
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        $coordinate->lat,
                        $coordinate->lng,
                    ]
                ],
                'properties' => [
                    'hintContent' => $device->name
                ],
                'options' => [
                    'iconColor' => $coordinate->getIconColor()
                ]
            ];
        }

        echo json_encode($json);
    }
}