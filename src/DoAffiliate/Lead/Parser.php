<?php

namespace Wearesho\Bobra\Cpa\DoAffiliate\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\DoAffiliate\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const UTM_SOURCE = 'doaff';
    protected const VISITOR = 'v';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::VISITOR, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::DO_AFFILIATE,
            ['visitor' => $query[static::VISITOR],]
        );
    }
}
