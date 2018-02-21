<?php

use yii\helpers\ArrayHelper;
use yii\db\Connection;

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'config-local.php';
$config = [
    'class' => \yii\web\Application::class,
    'id' => 'yii2-advanced-package',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'sqlite:' . getenv("DB_PATH"),
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
