<?php

use yii\helpers\ArrayHelper;
use yii\db\Connection;

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'config-local.php';

$dsn = getenv('DB_TYPE') . ":host=" . getenv("DB_HOST") . ";dbname=" . getenv("DB_NAME");

$config = [
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => $dsn,
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS') ?: '',
        ],
    ],
];

return ArrayHelper::merge(
    $config,
    is_file($localConfig) ? require $localConfig : []
);
