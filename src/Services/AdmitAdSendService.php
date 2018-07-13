<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class AdmitAdSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class AdmitAdSendService extends AbstractSendService
{
    public const ENV_POSTBACK_KEY = 'ADMITAD_POSTBACK_KEY';
    public const ENV_CAMPAIGN_CODE = 'ADMITAD_CAMPAIGN_CODE';

    /** @var string */
    public $postbackKey;

    /** @var string */
    public $campaignCode;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $uid = $params['uid'] ?? null;

        $params = [
            'campaign_code' => $this->campaignCode,
            'postback' => 1,
            'postback_key' => $this->postbackKey,
            'action_code' => 2,
            'uid' => $uid,
            'order_id' => $conversion,
            'tariff_code' => 1,
            'payment_type' => 'sale',
        ];

        return new Request(
            'get',
            "https://ad.admitad.com/r?" . http_build_query($params)
        );
    }

    public function isEnabled(): bool
    {
        return !empty($this->postbackKey) && !empty($this->campaignCode);
    }
}
