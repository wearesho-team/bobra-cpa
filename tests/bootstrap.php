<?php

// phpcs:ignoreFile

require_once(dirname(__DIR__) . '/vendor/autoload.php');

$dotEnv = new \Dotenv\Dotenv(dirname(__DIR__));
$dotEnv->load();

defined('YII_DEBUG') || define("YII_DEBUG", getenv("YII_DEBUG") ?: true);
defined('YII_ENV') || define("YII_ENV", getenv("YII_ENV") ?: "test");

getenv('DB_PATH') || putenv("DB_PATH=" . __DIR__ . '/db.sqlite');

require_once(dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php');

Yii::setAlias(
    '@Wearesho/Bobra/Cpa',
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src'
);
Yii::setAlias('@configFile', __DIR__ . DIRECTORY_SEPARATOR . 'config.php');

Yii::$container->set(
    \GuzzleHttp\ClientInterface::class,
    \Wearesho\Bobra\Cpa\Tests\Unit\Mocks\ClientMock::class
);
