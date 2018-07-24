<?php


namespace Wearesho\Bobra\Cpa\Tests\PrimeLead;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\PrimeLead
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\PrimeLead\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\PrimeLead\EnvironmentConfig();
    }

    public function testGetToken(): void
    {
        putenv('PRIME_LEAD_PRODUCT_PATH=TestPath');
        $this->assertEquals('TestPath', $this->config->getPath('product'));

        putenv('PRIME_LEAD_PRODUCT_PATH');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getPath('product');
    }
}
