<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit;

use Wearesho\Bobra\Cpa;
use yii\queue\sync\Queue;

/**
 * Class BootstrapTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit
 * @internal
 */
class BootstrapTest extends Cpa\Tests\AbstractTestCase
{
    protected $aliases;

    protected function setUp(): void
    {
        parent::setUp();
        $this->aliases = \Yii::$aliases;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Yii::$aliases = $this->aliases;
    }

    public function testBootstrap(): void
    {
        $bootstrap = new Cpa\Bootstrap();
        $bootstrap->bootstrap($this->app);

        $this->assertEquals(
            \Yii::getAlias('@vendor/wearesho-team/bobra-cpa/src'),
            \Yii::getAlias('@Wearesho/Bobra/Cpa')
        );

        $this->assertArrayHasKey('migrate', $this->app->controllerMap);
        $this->assertTrue(
            $this->container->has(Cpa\Conversion\ServiceInterface::class)
        );
        $this->assertInstanceOf(
            Cpa\Conversion\Sync\Service::class,
            $this->container->get(Cpa\Conversion\ServiceInterface::class)
        );
    }

    public function testBootstrapWithQueue(): void
    {
        $bootstrap = new Cpa\Bootstrap();
        $this->app->set('queue', new Queue);
        $bootstrap->bootstrap($this->app);

        $this->assertTrue(
            $this->container->has(Cpa\Conversion\ServiceInterface::class)
        );
        $this->assertInstanceOf(
            Cpa\Conversion\Queue\Service::class,
            $this->container->get(Cpa\Conversion\ServiceInterface::class)
        );
    }
}
