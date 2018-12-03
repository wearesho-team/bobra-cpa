<?php

namespace Wearesho\Bobra\Cpa\LinkProfit;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\LinkProfit
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'LINK_PROFIT_';

    public function getCampaignId(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'CAMPAIGN_ID');
    }
}
