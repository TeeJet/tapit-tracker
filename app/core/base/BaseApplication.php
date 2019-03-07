<?php

namespace app\core\base;

use app\models\User;

abstract class BaseApplication
{
    protected $controllerNamespace;
    protected $controllerPostfix;

    public function run($route, $db, $config)
    {
        App::$db = $db;
        App::$config = $config;

        try {
            $this->runAction($route);
        } catch (\Error $exception) {
            header("HTTP/1.0 404 Not Found");
            echo 'Page not found';
            exit;
        }
    }

    private function runAction($route)
    {
        $this->checkAuth($route);
        list($controllerName, $actionName) = explode('/',  $route);

        $controllerName = $this->controllerNamespace . ucfirst($controllerName) . $this->controllerPostfix;
        $controller = new $controllerName;

        $actionName = "action" . ucfirst($actionName);
        $controller->$actionName();
    }

    private function checkAuth($route)
    {
        session_start();
        if (!in_array($route, App::$config['route']['need-auth']) || isset($_SESSION['auth'])) {
            return;
        }

        $validated = User::checkAuth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

        if (!$validated) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            die ("You must be logged in");
        }

        $_SESSION['auth'] = true;
    }
}