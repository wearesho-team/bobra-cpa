<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

/**
 * Class RequestExceptionClientMock
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Mocks
 */
class RequestExceptionClientMock extends ClientMock
{
    const STATUS_CODE = 500;

    public function send(RequestInterface $request, array $options = [])
    {
        throw new RequestException(
            "Test error message",
            $request,
            new Response(static::STATUS_CODE)
        );
    }
}
