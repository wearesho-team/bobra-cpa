<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa\LinkProfit\EnvironmentConfig;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit
 */
class EnvironmentConfigTest extends TestCase
{
    public function testGetter(): void
    {
        $config = new EnvironmentConfig();
        putenv('LINK_PROFIT_CAMPAIGN_ID=123');
        $this->assertEquals('123', $config->getCampaignId());
    }

    public function testGetterWithProduct(): void
    {
        $config = new EnvironmentConfig();
        putenv('LINK_PROFIT_PRODUCT_CAMPAIGN_ID=123');
        $this->assertEquals('123', $config->getCampaignId('product'));
    }
}
