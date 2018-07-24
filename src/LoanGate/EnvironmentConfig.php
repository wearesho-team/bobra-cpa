<?php

namespace Wearesho\Bobra\Cpa\LoanGate;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\LoanGate
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'LOAN_GATE_';

    public function getGoal(?string $product = null): int
    {
        return $this->getEnv($this->getProductPrefix($product) . 'GOAL');
    }

    public function getSecure(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'SECURE');
    }
}
