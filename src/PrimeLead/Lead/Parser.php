<?php

namespace Wearesho\Bobra\Cpa\PrimeLead\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\PrimeLead\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const UTM_SOURCE = 'primelead';
    protected const TRANSACTION_ID = 'transaction_id';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::TRANSACTION_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::PRIME_LEAD,
            ['transactionId' => $query[static::TRANSACTION_ID],]
        );
    }
}
