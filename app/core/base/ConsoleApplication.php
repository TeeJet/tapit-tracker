<?php

namespace app\core\base;

class ConsoleApplication extends BaseApplication
{
    protected $controllerNamespace = "app\\commands\\";
    protected $controllerPostfix = "Command";

    public function run($params, $db, $config)
    {
        if (empty($params[1])) {
            echo 'Usage example: ./console.php socket/run';
            exit;
        }
        parent::run($params[1], $db, $config);
    }
}