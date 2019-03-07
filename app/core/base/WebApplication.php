<?php

namespace app\core\base;

class WebApplication extends BaseApplication
{
    public static $defaultRoute = "site/index";

    protected $controllerNamespace = "app\\controllers\\";
    protected $controllerPostfix = "Controller";

    public function run($params, $db, $config)
    {
        $route = $params['route'] ?? self::$defaultRoute;
        parent::run($route, $db, $config);
    }
}