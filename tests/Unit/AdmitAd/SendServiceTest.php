<?php


namespace Wearesho\Bobra\Cpa\Tests\AdmitAd;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\AdmitAd
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const UID = '123';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\AdmitAd\SendService([
            'config' => new class implements Cpa\AdmitAd\ConfigInterface
            {

                public function getPostbackKey(?string $product = null): string
                {
                    return 'postbackKey';
                }

                public function getCampaignCode(?string $product = null): string
                {
                    return 'campaignCode';
                }
            }
        ]);
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion([
            'uid' => static::UID,
        ]));
        $this->assertEquals(
            'GET',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'https://ad.admitad.com/r?campaign_code=campaignCode&postback=1&postback_key=postbackKey&action_code=2&uid=123&order_id=10&tariff_code=1&payment_type=sale', //phpcs:ignore
            (string)$tuple->getRequest()->getUri()
        );
    }
}
