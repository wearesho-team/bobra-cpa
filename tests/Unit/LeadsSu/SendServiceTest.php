<?php

namespace Wearesho\Bobra\Cpa\Tests\LeadsSu;

use GuzzleHttp;
use Wearesho\Bobra\Cpa;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\LeadsSu
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const TRANSACTION_ID = 20;

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\LeadsSu\SendService([
            'config' => new class implements Cpa\LeadsSu\ConfigInterface
            {

                public function getToken(?string $product = null): string
                {
                    return 'TestToken';
                }
            }
        ]);
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion([
            'transactionId' => static::TRANSACTION_ID,
        ]));
        $this->assertEquals(
            'POST',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://api.leads.su/advertiser/conversion/createUpdate?token=TestToken&goal_id=0&transaction_id=20&adv_sub=10&status=approved&comment=undefined', // phpcs:ignore
            (string)$tuple->getRequest()->getUri()
        );
    }
}
