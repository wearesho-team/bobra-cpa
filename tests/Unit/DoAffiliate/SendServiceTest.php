<?php

namespace Wearesho\Bobra\Cpa\Tests\DoAffiliate;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\DoAffiliate
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const VISITOR_UID = '2xkibry72rx';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\DoAffiliate\SendService([
            'config' => new class implements Cpa\DoAffiliate\ConfigInterface
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
            'visitor' => static::VISITOR_UID,
        ]));
        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://tracker2.doaffiliate.net/api/testPath?type=CPA&lead=1&sale=10&v=2xkibry72rx',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
