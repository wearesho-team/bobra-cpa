<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Letmeads;

use Wearesho\Bobra\Cpa;

use GuzzleHttp;

/**
 * Class SendServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Letmeads
 * @internal
 */
class SendServiceTest extends Cpa\Tests\Unit\Conversion\SendServiceTest
{
    public const LETMEADS_REF = 'testRef';

    public function testRequest(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);

        /** @noinspection PhpUnhandledExceptionInspection */
        $tuple = $this->sendService->send($this->mockConversion([
            'letmeadsRef' => static::LETMEADS_REF
        ]));

        $this->assertEquals('GET', $tuple->getRequest()->getMethod());
        $this->assertEquals(
            'https://ad.letmeads.com/api/v1.1/testPath/get/postback.json?code=Y&ref_id=10&click_id=testRef',
            (string)$tuple->getRequest()->getUri()
        );
    }

    protected function createSendService(): Cpa\Conversion\SendServiceInterface
    {
        return new Cpa\Letmeads\SendService([
            'config' => new class extends Cpa\Letmeads\EnvironmentConfig
            {
                public function getPath(?string $product = null): string
                {
                    return 'testPath';
                }
            },
        ]);
    }
}
