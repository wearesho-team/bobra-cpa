<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LeadGid;

use GuzzleHttp\Psr7\Response;
use Wearesho\Bobra\Cpa;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LeadGid
 * @coversDefaultClass \Wearesho\Bobra\Cpa\LeadGid\LeadModel
 * @internal
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    /**
     * @internal
     */
    public const ID = 'testId';

    /** @var Cpa\LeadGid\LeadModel */
    protected $fakeLeadModel;

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\LeadGid\SendService([
            'config' => new class implements Cpa\LeadGid\ConfigInterface
            {
                public function getOfferId(?string $product = null): string
                {
                    return SendServiceTest::ID;
                }
            },
        ]);
    }

    public function testRequest(): void
    {
        $response = new Response();
        $this->mock->append($response);

        $tuple = $this->sendService->send($this->mockConversion([
            'clickId' => static::ID,
        ]));

        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
    }
}
