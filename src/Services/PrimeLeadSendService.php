<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class PrimeLeadSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class PrimeLeadSendService extends AbstractSendService
{
    public const ENV_PATH_KEY = 'PRIME_LEAD_PATH';

    /** @var string */
    public $path;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $transactionId = $params['transactionId'] ?? null;

        return new Request(
            "get",
            "http://primeadv.go2cloud.org/{$this->path}?adv_sub={$conversion}&transaction_id={$transactionId}"
        );
    }

    public function isEnabled(): bool
    {
        return !empty($this->path);
    }
}
