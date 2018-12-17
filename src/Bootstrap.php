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
class Bootstrap extends base\BaseObject implements base\BootstrapInterface
{
    use BootstrapMigrations;

    /** @var array|string|Cpa\Lead\Parser */
    public $parser = [
        'class' => Cpa\Lead\Parser\Chain::class,
    ];

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        $app->setAliases([
            '@Wearesho/Bobra/Cpa' => '@vendor/wearesho-team/bobra-cpa/src',
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

        \Yii::$container->set(Cpa\Lead\Parser::class, $this->parser);
    }
}
