<?php

namespace Wearesho\Bobra\Cpa\Tests\LeadsSu;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\LeadsSu
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\LeadsSu\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\LeadsSu\EnvironmentConfig();
    }

    public function testGetToken(): void
    {
        putenv('LEADS_SU_PRODUCT_TOKEN=TestToken');
        $this->assertEquals('TestToken', $this->config->getToken('product'));

        putenv('LEADS_SU_PRODUCT_TOKEN');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getToken('product');
    }
}
