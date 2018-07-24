<?php

namespace Wearesho\Bobra\Cpa\SalesDoubler;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\SalesDoubler
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'SALES_DOUBLER_';

    public function getId(?string $product = null): int
    {
        return $this->getEnv($this->getProductPrefix($product) . 'ID');
    }

    public function getToken(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'TOKEN');
    }
}
