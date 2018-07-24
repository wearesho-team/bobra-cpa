<?php

namespace Wearesho\Bobra\Cpa\Tests\PrimeLead;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\PrimeLead
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const TRANSACTION_ID = 'TTID';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\PrimeLead\SendService([
            'config' => new class implements Cpa\PrimeLead\ConfigInterface
            {

                public function getPath(?string $product = null): string
                {
                    return 'TestPath';
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
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://primeadv.go2cloud.org/TestPath?adv_sub=10&transaction_id=TTID',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
