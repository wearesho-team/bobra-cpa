<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class SalesDoublerSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class SalesDoublerSendService extends AbstractSendService
{
    const ENV_TOKEN_KEY = 'SALES_DOUBLER_TOKEN';

    /** @var string */
    public $token;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $clickId = $params['clickId'] ?? null;
        $transId = $conversion;
        $token = $this->token;

        $url = "http://rdr.salesdoubler.com.ua/in/postback/586/{$clickId}?trans_id={$transId}&token={$token}";

        return new Request('get', $url);
    }

    public function isEnabled(): bool
    {
        return !empty($this->token);
    }
}
