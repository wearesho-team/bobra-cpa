<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Lead;

use Wearesho\Bobra\Cpa\Lead;
use Wearesho\Bobra\Cpa\Lead\Service;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\ParserMock;

/**
 * Class ServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Lead
 */
class ServiceTest extends AbstractTestCase
{
    public function testUnsuccessful(): void
    {
        $service = new Service(new ParserMock(false));
        $lead = $service->create(1, ['test']);
        $this->assertNull($lead);
    }

    public function testSuccessful(): void
    {
        $service = new Service(new ParserMock());
        $lead = $service->create(1, ['test']);

        $this->assertInstanceOf(Lead::class, $lead);
        $this->assertEquals('test', $lead->source);
        $this->assertEquals(['testField' => 'testValue',], $lead->config);
        $this->assertEquals(1, $lead->user_id);
    }
}
