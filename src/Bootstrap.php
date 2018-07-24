<?php

namespace Wearesho\Bobra\Cpa;

use Horat1us\Yii\Traits\BootstrapMigrations;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\console;

/**
 * Class Bootstrap
 * @package Wearesho\Bobra\Cpa
 */
class Bootstrap implements base\BootstrapInterface
{
    use BootstrapMigrations;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->setAliases([
            '@Wearesho\Bobra\Cpa' => '@vendor/wearesho-team/bobra-cpa',
        ]);

        if ($app instanceof console\Application) {
            $this->appendMigrations(
                $app,
                'Wearesho\\Bobra\\Cpa\\Migrations'
            );
        }

        \Yii::$container->set(
            Cpa\Conversion\ServiceInterface::class,
            $app->has('queue')
                ? Cpa\Conversion\Queue\Service::class
                : Cpa\Conversion\Sync\Service::class
        );
    }
}
