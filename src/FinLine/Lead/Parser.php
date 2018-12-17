<?php

namespace Wearesho\Bobra\Cpa\FinLine\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\FinLine\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const UTM_SOURCE = 'finline';
    protected const CLICK_ID = 'clickid';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::CLICK_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::FIN_LINE,
            ['clickId' => $query[static::CLICK_ID],]
        );
    }
}
