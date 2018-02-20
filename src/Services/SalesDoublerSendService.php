<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\ClientInterface;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Wearesho\Bobra\Cpa\Entities\PostbackTuple;
use Wearesho\Bobra\Cpa\Interfaces\ConversionSenderInterface;

/**
 * Class SalesDoublerSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class SalesDoublerSendService implements ConversionSenderInterface
{
    const ENV_TOKEN_KEY = 'SALES_DOUBLER_TOKEN';

    /** @var string */
    public $token;

    /** @var ClientInterface */
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function send(string $conversion, array $params): PostbackTuple
    {
        $clickId = $params['clickId'] ?? null;
        $transId = $conversion;
        $token = $this->token;

        $url = "http://rdr.salesdoubler.com.ua/in/postback/586/{$clickId}?trans_id={$transId}&token={$token}";

        $request = new Request('get', $url);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            return new PostbackTuple($request, $e->getResponse());
        } catch (GuzzleException $e) {
            return new PostbackTuple($request);
        }

        return new PostbackTuple($request, $response);
    }

    public function isEnabled(): bool
    {
        return is_string($this->token);
    }
}
