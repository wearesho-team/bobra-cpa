<?php

namespace Wearesho\Bobra\Cpa\FinLine;

use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\FinLine
 */
class SendService implements Cpa\Conversion\SendServiceInterface
{
    use Cpa\Conversion\SendServiceTrait;

    protected const STATUS_APPROVED = 1;
    protected const STATUS_PENDING = 2;
    protected const STATUS_DECLINED = 3;

    protected function getRequest(Cpa\ConversionInterface $conversion): RequestInterface
    {
        $clickId = $conversion->getConfig()['clickId'] ?? null;

        $url = "http://offers.finline.affise.com/postback?clickid={$clickId}&action_id={$conversion->getId()}&status="
            . static::STATUS_APPROVED;

        return new Psr7\Request("post", $url);
    }
}
