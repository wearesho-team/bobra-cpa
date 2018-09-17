<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LeadGid;

use Horat1us\Environment\MissingEnvironmentException;
use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa\LeadGid\EnvironmentConfig;

/**
 * Class EnvironmentConfigTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LeadGid
 * @coversDefaultClass EnvironmentConfig
 * @internal
 */
class EnvironmentConfigTest extends TestCase
{
    protected const ID = 'testId';

    /** @var EnvironmentConfig */
    protected $fakeEnvironmentConfig;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeEnvironmentConfig = new EnvironmentConfig();
    }

    public function testCorrectOfferId(): void
    {
        putenv('LEAD_GID_PRODUCT_OFFER_ID=' . static::ID);
        
        $this->assertEquals(
            static::ID,
            $this->fakeEnvironmentConfig->getOfferId('product')
        );
    }

    public function testMissingOfferId(): void
    {
        putenv('LEAD_GID_PRODUCT_OFFER_ID');

        $this->expectException(MissingEnvironmentException::class);
        $this->fakeEnvironmentConfig->getOfferId();
    }
}
