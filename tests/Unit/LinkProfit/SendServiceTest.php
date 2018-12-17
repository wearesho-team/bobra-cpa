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

    public function testSuccessfulResponse(): void
    {
        $this->mock->append(new GuzzleHttp\Psr7\Response());
        parent::testSuccessfulResponse();
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response, $response);
        $tuple = $this->sendService->send($this->mockConversion([
            'clickHash' => 111,
            'refId' => 222,
        ]));
        $this->assertEquals(2, count($this->history));

        $initialUrl = 'https://cpa.linkprofit.ru/sale?OrderID=10&ClickHash=111&CampaignID=123&AffiliateID=222';

        /** @var GuzzleHttp\Psr7\Request $request */
        $request = $this->history[0]['request'];
        $this->assertEquals($initialUrl, (string)$request->getUri());

        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://s.linkprofit.ru/postback//update/10?Status=A',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
