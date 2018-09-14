<?php

namespace Wearesho\Bobra\Cpa\LeadGid;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa\EnvironmentConfigTrait;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\LeadGid
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'LEAD_GID_';

    public function getOfferId(string $product = null): string
    {
        return $this->getEnv($this->appendProductPrefix('OFFER_ID', $product));
    }
}
