#!/usr/bin/php
<?php

use app\core\base\App;
use app\core\db\PgSql;

include_once __DIR__ . "/../autoload.php";
require_once __DIR__ . '/../config.php';

$sql = file_get_contents(__DIR__ . '/dump.sql');

$db = new PgSql($config['db']);

$result = $db->pdo->exec($sql);

if ($result === false) {
    $error = $db->pdo->errorInfo();
    echo $error[2] . PHP_EOL;
    exit;
}

$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$password = '';
$max = strlen($characters) - 1;
for ($i = 0; $i < 8; $i++) {
    $password .= $characters[mt_rand(0, $max)];
}

App::$db = new PgSql($config['db']);

$user = new \app\models\User();
$user->username = "admin";
$user->password = password_hash($password, PASSWORD_DEFAULT);
if (!$user->save()) {
    echo "Can't save admin user" . PHP_EOL;
    exit;
}

echo "Install completed" . PHP_EOL;
echo "Admin's authorization data. Write it to a safe place:" . PHP_EOL;
echo "Username: admin" . PHP_EOL;
echo "Password: " . $password . PHP_EOL;

unlink(__DIR__ . "/dump.sql");
unlink(__DIR__ . "/install.php");
rmdir(__DIR__);