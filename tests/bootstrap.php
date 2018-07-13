<?php

// phpcs:ignoreFile

defined('YII_DEBUG') || define("YII_DEBUG", true);
defined('YII_ENV') || define("YII_ENV", "test");

getenv('DB_PATH') || putenv("DB_PATH=" . __DIR__ . '/db.sqlite');

require_once(dirname(__DIR__) . '/vendor/autoload.php');
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
