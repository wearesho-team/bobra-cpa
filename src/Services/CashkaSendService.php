<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class CashkaSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class CashkaSendService extends AbstractSendService
{
    public const ENV_PATH_KEY = 'CASHKA_PATH';

    /** @var string */
    public $path;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $transactionId = $params['transactionId'] ?? null;

        return new Request(
            "get",
            "http://track.cashka.com.ua/{$this->path}?adv_sub={$conversion}&transaction_id={$transactionId}"
        );
    }

    public function isEnabled(): bool
    {
        return !empty($this->path);
    }
}
