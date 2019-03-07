<?php

namespace app\commands;

use app\components\TrackerSocketServer;
use app\core\base\App;

class SocketCommand
{
    public function actionRun()
    {
        $socket = new TrackerSocketServer(App::$config['socket']);
        $socket->run();
    }
}