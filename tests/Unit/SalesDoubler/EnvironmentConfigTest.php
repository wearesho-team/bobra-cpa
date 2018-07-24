<?php

namespace Wearesho\Bobra\Cpa\Tests\SalesDoubler;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\SalesDoubler
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\SalesDoubler\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\SalesDoubler\EnvironmentConfig();
    }

    public function testGetId(): void
    {
        putenv('SALES_DOUBLER_PRODUCT_ID=123');
        $this->assertEquals(123, $this->config->getId('product'));

        putenv('SALES_DOUBLER_PRODUCT_ID');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getId('product');
    }

    public function testGetToken(): void
    {
        putenv('SALES_DOUBLER_PRODUCT_TOKEN=TestToken');
        $this->assertEquals('TestToken', $this->config->getToken('product'));

        putenv('SALES_DOUBLER_PRODUCT_TOKEN');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getToken('product');
    }
}
