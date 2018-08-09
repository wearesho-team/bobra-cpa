<?php

namespace Wearesho\Bobra\Cpa\Letmeads;

use Horat1us\Environment;

use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\Letmeads
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'LETMEADS_';

    public function getPath(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'PATH');
    }
}
