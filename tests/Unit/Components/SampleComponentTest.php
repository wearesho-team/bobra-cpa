<?php

namespace Horat1us\Package\Tests\Unit\Components;

use Horat1us\Package\Components\SampleComponent;
use yii\phpunit\TestCase;

/**
 * Class SampleComponentTest
 * @package Horat1us\Package\Tests\Unit\Components
 *
 * @internal
 */
class SampleComponentTest extends TestCase
{
    /** @var SampleComponent */
    protected $component;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected function setUp()
    {
        parent::setUp();
        $this->component = $this->container->get(SampleComponent::class);
    }

    public function testTriggeringEvent()
    {
        $eventTriggered = false;
        $this->component->on(SampleComponent::EVENT_SOMETHING_DONE, function () use (&$eventTriggered) {
            $eventTriggered = true;
        });
        $this->component->doSomething();
        $this->assertTrue($eventTriggered);
    }
}
