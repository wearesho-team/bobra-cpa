<?php


namespace Horat1us\Package\Tests\Behaviors;


use Horat1us\Package\Behaviors\PackageBehavior;
use Horat1us\Package\Tests\Mocks\ComponentMock;
use yii\base\Event;
use yii\phpunit\TestCase;

/**
 * Class PackageBehaviorTest
 * @package Horat1us\Package\Tests\Behaviors
 *
 * @internal
 */
class PackageBehaviorTest extends TestCase
{
    public function testTriggering()
    {
        /** @var ComponentMock $mock */
        $mock = $this->container->get(ComponentMock::class);
        $mock->trigger(PackageBehavior::EVENT_WAIT);
        $this->assertTrue($mock->waited);

        // no exception
        $mock->trigger(PackageBehavior::EVENT_WAIT, new Event(['sender' => new \stdClass()]));
    }
}
