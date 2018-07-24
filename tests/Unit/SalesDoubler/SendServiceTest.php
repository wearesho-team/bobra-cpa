<?php

namespace Wearesho\Bobra\Cpa\Tests\SalesDoubler;

use GuzzleHttp;
use Wearesho\Bobra\Cpa;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\SalesDoubler
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const CLICK_ID = 'ClickIdTest';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\SalesDoubler\SendService([
            'config' => new class implements Cpa\SalesDoubler\ConfigInterface
            {

                public function getId(?string $product = null): int
                {
                    return 322;
                }

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
            'clickId' => static::CLICK_ID,
        ]));
        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://rdr.salesdoubler.com.ua/in/postback/322/ClickIdTest?trans_id=10&token=TestToken',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
