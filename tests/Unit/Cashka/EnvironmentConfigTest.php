<?php

namespace Wearesho\Bobra\Cpa\Tests\Cashka;

use Horat1us\Environment\MissingEnvironmentException;
use Wearesho\Bobra\Cpa;
use PHPUnit\Framework\TestCase;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\Cashka
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\Cashka\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\Cashka\EnvironmentConfig();
    }

    public function testGetPath(): void
    {
        putenv('CASHKA_PRODUCT_PATH=1');
        $this->assertEquals(1, $this->config->getPath('product'));
        putenv('CASHKA_PRODUCT_PATH');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getPath('product');
    }
}
