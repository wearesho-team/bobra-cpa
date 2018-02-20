<?php


namespace Horat1us\Package\Tests\Mocks;


use Horat1us\Package\Behaviors\PackageBehavior;
use yii\base\Component;

/**
 * Class ComponentMock
 * @package Horat1us\Package\Tests\Mocks
 *
 * @internal
 */
class ComponentMock extends Component
{
    /** @var bool */
    public $waited = false;

    public function behaviors()
    {
        return [
            'package' => PackageBehavior::class,
        ];
    }
}
