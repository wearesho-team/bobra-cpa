<?php


namespace Wearesho\Bobra\Cpa\Tests\LoanGate;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\LoanGate
 */
class EnvironmentConfigTest extends TestCase
{
    /** @var Cpa\LoanGate\EnvironmentConfig */
    protected $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->config = new Cpa\LoanGate\EnvironmentConfig();
    }

    public function testGetGoal(): void
    {
        putenv('LOAN_GATE_PRODUCT_GOAL=3');
        $this->assertEquals(3, $this->config->getGoal('product'));

        putenv('LOAN_GATE_PRODUCT_GOAL');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getSecure('product');
    }

    public function testGetSecure(): void
    {
        putenv('LOAN_GATE_PRODUCT_SECURE=TestSecure');
        $this->assertEquals('TestSecure', $this->config->getSecure('product'));

        putenv('LOAN_GATE_PRODUCT_SECURE');
        $this->expectException(MissingEnvironmentException::class);
        $this->config->getSecure('product');
    }
}
