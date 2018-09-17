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
    /** @var Cpa\LeadGid\LeadModel */
    protected $fakeLeadModel;

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\LeadGid\SendService([
            'config' => new class implements Cpa\LeadGid\ConfigInterface
            {
                public function getOfferId(?string $product = null): string
                {
                    return '1234';
                }
            },
        ]);
    }

    public function testRequest(): void
    {
        $response = new Response();
        $this->mock->append($response);

        $tuple = $this->sendService->send($this->mockConversion([
            'clickId' => 1100,
        ]));

        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );

        $this->assertEquals(
            'http://go.leadgid.ru/aff_lsr?offer_id=1234&adv_sub=10&transaction_id=1100',
            $tuple->getRequest()->getUri()->__toString()
        );
    }
}
