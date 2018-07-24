<?php

namespace Wearesho\Bobra\Cpa\Tests\AdmitAd;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\AdmitAd
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\AdmitAd\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\AdmitAd\EnvironmentConfig();
    }

    public function testGetPostbackKey(): void
    {
        putenv('ADMITAD_POSTBACK_KEY=3');
        $this->assertEquals(3, $this->config->getPostbackKey());
        putenv('ADMITAD_POSTBACK_KEY');

        putenv('ADMITAD_PRODUCT_POSTBACK_KEY=1');
        $this->assertEquals(1, $this->config->getPostbackKey('product'));

        putenv('ADMITAD_PRODUCT_POSTBACK_KEY');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getPostbackKey('product');
    }

    public function testGetCampaignCode(): void
    {
        putenv('ADMITAD_PRODUCT_CAMPAIGN_CODE=2');
        $this->assertEquals(2, $this->config->getCampaignCode('product'));

        putenv('ADMITAD_PRODUCT_CAMPAIGN_CODE');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getCampaignCode('product');
    }
}
