<?php

// phpcs:ignoreFile

require_once(dirname(__DIR__) . '/vendor/autoload.php');

if (file_exists(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env')) {
    $dotEnv = new \Dotenv\Dotenv(dirname(__DIR__));
    $dotEnv->load();
}

defined('YII_DEBUG') || define("YII_DEBUG", getenv("YII_DEBUG") ?: true);
defined('YII_ENV') || define("YII_ENV", getenv("YII_ENV") ?: "test");

require_once(dirname(__DIR__) . '/vendor/yiisoft/yii2/Yii.php');

Yii::setAlias(
    '@Wearesho/Bobra/Cpa',
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src'
);
Yii::setAlias('@configFile', __DIR__ . DIRECTORY_SEPARATOR . 'config.php');
