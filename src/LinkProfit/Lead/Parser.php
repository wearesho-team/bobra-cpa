<?php

namespace Wearesho\Bobra\Cpa\LinkProfit\Lead;

use Wearesho\Bobra\Cpa\Lead;
use Wearesho\Bobra\Cpa\Lead\Info;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\LinkProfit\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    public function parse(string $url): ?Info
    {
        $query = $this->getQueryParams($url);

        $isValid = array_key_exists('wm_id', $query)
            && array_key_exists('click_hash', $query)
            && (($query['utm_source'] ?? null) === 'linkprofit');

        if (!$isValid) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::LINK_PROFIT,
            [
                'clickHash' => $query['click_hash'],
                'refId' => $query['wm_id'],
            ]
        );
    }
}
