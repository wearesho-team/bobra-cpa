<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Exception\GuzzleException;

class GuzzleExceptionClientMock extends ClientMock
{
    public function send(RequestInterface $request, array $options = [])
    {
        throw new class extends \Exception implements GuzzleException {};
    }
}
