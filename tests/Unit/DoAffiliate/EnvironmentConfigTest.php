<?php

namespace Wearesho\Bobra\Cpa\Tests\DoAffiliate;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\DoAffiliate
 * @internal
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\DoAffiliate\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\DoAffiliate\EnvironmentConfig();
    }

    public function testGetPath(): void
    {
        putenv('DO_AFFILIATE_PRODUCT_PATH=1');
        $this->assertEquals(1, $this->config->getPath('product'));
        putenv('DO_AFFILIATE_PRODUCT_PATH');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getPath('product');
    }
}
