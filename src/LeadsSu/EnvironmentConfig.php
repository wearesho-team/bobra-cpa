<?php

namespace Wearesho\Bobra\Cpa\LeadsSu;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\LeadsSu
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'LEADS_SU_';

    public function getToken(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'TOKEN');
    }
}
