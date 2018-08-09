<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Letmeads;

use Horat1us\Environment\MissingEnvironmentException;

use PHPUnit\Framework\TestCase;

use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Letmeads
 * @internal
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\Letmeads\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\Letmeads\EnvironmentConfig();
    }

    public function testGetPath(): void
    {
        putenv('LETMEADS_PRODUCT_PATH=TestPath');
        $this->assertEquals('TestPath', $this->config->getPath('product'));

        putenv('LETMEADS_PRODUCT_PATH');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getPath('product');
    }

    public function testGetLEtmeadsId(): void
    {
        putenv('LETMEADS_PRODUCT_REF=1234567890');
        $this->assertEquals('1234567890', $this->config->getRef('product'));

        putenv('LETMEADS_PRODUCT_REF');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getRef('product');
    }
}
