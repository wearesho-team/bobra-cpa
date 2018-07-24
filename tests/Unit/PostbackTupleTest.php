<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit;

use GuzzleHttp\Psr7;
use Wearesho\Bobra\Cpa;

/**
 * Class PostbackTuple
 * @package Wearesho\Bobra\Cpa\Tests\Unit
 * @internal
 */
class PostbackTupleTest extends Cpa\Tests\AbstractTestCase
{
    public function testGetRequest(): void
    {
        $request = $this->mockRequest();
        $tuple = new Cpa\PostbackTuple($request);
        $this->assertEquals($request, $tuple->getRequest());
    }

    public function testGetEmptyResponse(): void
    {
        $request = $this->mockRequest();
        $tuple = new Cpa\PostbackTuple($request);
        $this->assertNull($tuple->getResponse());
    }

    public function testGetResponse(): void
    {
        $request = $this->mockRequest();
        $response = $this->mockResponse();
        $tuple = new Cpa\PostbackTuple($request, $response);
        $this->assertEquals($response, $tuple->getResponse());
    }

    protected function mockRequest(): Psr7\Request
    {
        return new Psr7\Request('get', 'https://wearesho.com/');
    }

    protected function mockResponse(): Psr7\Response
    {
        return new Psr7\Response();
    }
}
