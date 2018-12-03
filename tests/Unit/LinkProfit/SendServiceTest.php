<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit;

use GuzzleHttp;
use Wearesho\Bobra\Cpa;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        $config = new Cpa\LinkProfit\EnvironmentConfig();
        putenv('LINK_PROFIT_CAMPAIGN_ID=123');

        return new Cpa\LinkProfit\SendService([
            'config' => $config,
        ]);
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion([
            'clickHash' => 111,
            'refId' => 222,
        ]));
        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'https://cpa.linkprofit.ru/sale?OrderID=10&ClickHash=111&CampaignID=123&AffiliateID=222', // phpcs:ignore
            (string)$tuple->getRequest()->getUri()
        );
    }
}
