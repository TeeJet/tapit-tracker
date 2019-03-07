<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../config.php';

$application = new app\core\base\WebApplication();
$application->run($_REQUEST, new app\core\db\PgSql($config['db']), $config);