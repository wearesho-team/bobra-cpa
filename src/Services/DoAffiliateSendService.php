<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class DoAffiliateSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class DoAffiliateSendService extends AbstractSendService
{
    public const ENV_PATH_KEY = 'DO_AFFILIATE_PATH';

    /** @var string */
    public $path;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $visitor = $params['visitor'] ?? null;
        $user = $params['user'] ?? null;
        $url = "http://tracker2.doaffiliate.net/api/{$this->path}?type=CPA&lead={$user}&sale={$conversion}&v={$visitor}";
        return new Request("post", $url);
    }

    public function isEnabled(): bool
    {
        return !empty($this->path);
    }
}
