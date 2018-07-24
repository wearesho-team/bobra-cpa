<?php

namespace Wearesho\Bobra\Cpa\DoAffiliate;

use Wearesho\Bobra\Cpa;
use Horat1us\Environment;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\DoAffiliate
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'DO_AFFILIATE_';

    public function getPath(?string $product = null): string
    {
        return $this->getEnv($this->appendProductPrefix('PATH', $product));
    }
}
