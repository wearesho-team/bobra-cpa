<?php

namespace Wearesho\Bobra\Cpa\Tests\Cashka;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Cashka
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const TRANSACTION_ID = 'TestTransactionId';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\Cashka\SendService([
            'config' => new class implements Cpa\Cashka\ConfigInterface
            {

                public function getPath(?string $product = null): string
                {
                    return 'testPath';
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
            'http://track.cashka.com.ua/testPath?adv_sub=10&transaction_id=TestTransactionId',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
