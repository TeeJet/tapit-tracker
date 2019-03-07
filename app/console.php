#!/usr/bin/php
<?php

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/config.php';

$application = new \app\core\base\ConsoleApplication();
$application->run($argv, new app\core\db\PgSql($config['db']), $config);