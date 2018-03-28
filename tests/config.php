<?php

use yii\helpers\ArrayHelper;
use yii\db\Connection;

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'config-local.php';

$dsn = getenv('DB_TYPE') . ":host=" . getenv("DB_HOST") . ";dbname=" . getenv("DB_NAME");

$config = [
    'class' => \yii\web\Application::class,
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => $dsn,
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS') ?: '',
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \Wearesho\Bobra\Cpa\Tests\Unit\Mocks\UserMock::class,
        ]
    ],
];

return ArrayHelper::merge(
    $config,
    is_file($localConfig) ? require $localConfig : []
);
