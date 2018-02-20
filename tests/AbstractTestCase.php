<?php

namespace Horat1us\Package\Tests;

use yii\helpers\ArrayHelper;
use yii\phpunit\MigrateFixture;
use yii\phpunit\TestCase;

/**
 * Class AbstractTestCase
 * @package Horat1us\Package\Tests
 *
 * @internal
 */
abstract class AbstractTestCase extends TestCase
{
    public function globalFixtures()
    {
        $fixtures = [
            [
                'class' => MigrateFixture::class,
                'migrationNamespaces' => [
                    'Horat1us\\Package\\Migrations',
                ]
            ]
        ];

        return ArrayHelper::merge(parent::globalFixtures(), $fixtures);
    }
}
