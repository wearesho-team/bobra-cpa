<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ClientMock implements ClientInterface
{
    public function send(RequestInterface $request, array $options = [])
    {
        return new Response();
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
    }

    public function request($method, $uri, array $options = [])
    {
    }

    public function requestAsync($method, $uri, array $options = [])
    {
    }

    public function getConfig($option = null)
    {
    }
}
