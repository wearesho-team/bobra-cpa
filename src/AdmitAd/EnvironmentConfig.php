<?php

namespace Wearesho\Bobra\Cpa\AdmitAd;

use Horat1us\Environment;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfig
 * @package Wearesho\Bobra\Cpa\AdmitAd
 */
class EnvironmentConfig extends Environment\Yii2\Config implements ConfigInterface
{
    use Cpa\EnvironmentConfigTrait;

    public $keyPrefix = 'ADMITAD_';

    public function getPostbackKey(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'POSTBACK_KEY');
    }

    public function getCampaignCode(?string $product = null): string
    {
        return $this->getEnv($this->getProductPrefix($product) . 'CAMPAIGN_CODE');
    }
}
