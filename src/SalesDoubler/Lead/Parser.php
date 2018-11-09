<?php

namespace Wearesho\Bobra\Cpa\SalesDoubler\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\SalesDoubler\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const AFF_SUB = 'aff_sub';
    protected const UTM_SOURCES = [
        'cpanet_salesdoubler',
        'cpanet_salesdubler',
        'salesdoubler'
    ];

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        $isQueryValid = in_array($query['utm_source'] ?? null, static::UTM_SOURCES, true)
            && array_key_exists(static::AFF_SUB, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::SALES_DOUBLER,
            [
                'clickId' => $query[static::AFF_SUB],
                'aid' => $query['utm_campaign'] ?? $query['aff_id'] ?? null,
            ]
        );
    }
}
