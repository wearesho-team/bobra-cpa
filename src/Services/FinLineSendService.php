<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class FinLineSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class FinLineSendService extends AbstractSendService
{
    protected const STATUS_APPROVED = 1;
    protected const STATUS_PENDING = 2;
    protected const STATUS_DECLINED = 3;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $clickId = $params['clickId'] ?? null;

        $url = "http://offers.finline.affise.com/postback?clickid={$clickId}&action_id={$conversion}&status="
            . static::STATUS_APPROVED;
        return new Request("post", $url);
    }

    public function isEnabled(): bool
    {
        return true;
    }
}
