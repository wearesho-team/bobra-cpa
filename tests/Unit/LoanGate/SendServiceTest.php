<?php

namespace Wearesho\Bobra\Cpa\Tests\LoanGate;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\LoanGate
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const AFCLICK = 20;

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\LoanGate\SendService([
            'config' => new class implements Cpa\LoanGate\ConfigInterface
            {

                public function getGoal(?string $product = null): int
                {
                    return 30;
                }

                public function getSecure(?string $product = null): string
                {
                    return 'testSecure';
                }
            }
        ]);
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion([
            'afclick' => static::AFCLICK,
        ]));
        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://offers.loangate.affise.com/postback?clickId=20&action_id=10&goal=30&secure=testSecure',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
