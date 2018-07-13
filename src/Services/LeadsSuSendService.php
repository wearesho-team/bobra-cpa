<?php

namespace Wearesho\Bobra\Cpa\Services;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class LeadsSuSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class LeadsSuSendService extends AbstractSendService
{
    public const ENV_TOKEN_KEY = 'LEADS_SU_TOKEN';

    protected const STATUS_REJECTED = 'rejected';
    protected const STATUS_PENDING = 'pending';
    protected const STATUS_APPROVED = 'approved';

    /** @var string */
    public $token;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $transactionId = $params['transactionId'] ?? null;

        $params = [
            'token' => $this->token,
            'goal_id' => 0,
            'transaction_id' => $transactionId,
            'adv_sub' => $conversion,
            'status' => static::STATUS_APPROVED,
            'comment' => 'undefined',
        ];

        $url = "http://api.leads.su/advertiser/conversion/createUpdate?" . http_build_query($params);
        return new Request("post", $url);
    }

    public function isEnabled(): bool
    {
        return !empty($this->token);
    }
}
