<?php

namespace Wearesho\Bobra\Cpa\Tests\FinLine;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\FinLine
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    protected const CLICK_ID = 'ClickIdentifier';

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\FinLine\SendService();
    }

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion([
            'clickId' => static:: CLICK_ID,
        ]));
        $this->assertEquals(
            'POST',
            $tuple->getRequest()->getMethod()
        );
        $this->assertEquals(
            'http://offers.finline.affise.com/postback?clickid=ClickIdentifier&action_id=10&status=1',
            (string)$tuple->getRequest()->getUri()
        );
    }
}
