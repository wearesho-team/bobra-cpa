<?php

use yii\helpers\ArrayHelper;
use yii\db\Connection;

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'config-local.php';

$dbType = getenv('DB_TYPE') ?: 'pgsql';
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbName = getenv('DB_NAME') ?: 'bobra_cpa';

$dsn = "{$dbType}:host={$dbHost};dbname={$dbName}";

$config = [
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => $dsn,
            'username' => getenv('DB_USER') ?: 'postgres',
            'password' => getenv('DB_PASS') ?: '',
        ],
    ],
];

return ArrayHelper::merge(
    $config,
    is_file($localConfig) ? require $localConfig : []
);
