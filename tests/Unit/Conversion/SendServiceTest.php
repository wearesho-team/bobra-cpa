<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Conversion;

use Psr\Http\Message\RequestInterface;
use Throwable;
use Wearesho\Bobra\Cpa;
use GuzzleHttp;

/**
 * Class SendServiceTraitTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Conversion
 * @internal
 */
abstract class SendServiceTest extends Cpa\Tests\AbstractTestCase
{
    protected const USER_ID = 1;
    protected const CONVERSION_ID = 10;
    protected const LEAD_ID = 100;

    /** @var Cpa\Conversion\SendServiceTrait */
    protected $sendService;

    /** @var GuzzleHttp\Handler\MockHandler */
    protected $mock;

    /** @var array[] */
    protected $history;

    protected function setUp(): void
    {
        parent::setUp();

        $this->history = [];
        $this->mock = new GuzzleHttp\Handler\MockHandler();
        $history = GuzzleHttp\Middleware::history($this->history);
        $stack = new GuzzleHttp\HandlerStack($this->mock);
        $stack->push($history);

        $this->container->set(
            GuzzleHttp\ClientInterface::class,
            function () use ($stack): GuzzleHttp\ClientInterface {
                return new GuzzleHttp\Client([
                    'handler' => $stack,
                ]);
            }
        );

        $this->sendService = $this->createSendService();
    }

    abstract protected function createSendService(): Cpa\Conversion\SendServiceInterface;

    public function testHandlingGuzzleException(): void
    {
        $this->mock->append(new GuzzleHttp\Exception\TransferException);
        $tuple = $this->sendService->send($this->mockConversion());
        $this->assertNull($tuple->getResponse());
    }

    public function testHandlingRequestException(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append(new GuzzleHttp\Exception\RequestException(
            'msg',
            new GuzzleHttp\Psr7\Request('get', 'https://wearesho.com/'),
            $response
        ));
        $tuple = $this->sendService->send($this->mockConversion());
        $this->assertEquals($response, $tuple->getResponse());
    }


    public function testSuccessfulResponse(): void
    {
        $response = new GuzzleHttp\Psr7\Response();
        $this->mock->append($response);
        $tuple = $this->sendService->send($this->mockConversion());
        $this->assertEquals($response, $tuple->getResponse());
    }

    abstract public function testRequest(): void;

    protected function mockConversion(array $config = []): Cpa\ConversionInterface
    {
        return new Cpa\Conversion([
            'conversion_id' => static::CONVERSION_ID,
            'lead' => new Cpa\Lead([
                'id' => static::LEAD_ID,
                'config' => $config,
                'user_id' => static::USER_ID,
            ]),
        ]);
    }
}
