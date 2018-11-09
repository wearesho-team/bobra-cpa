<?php

namespace Wearesho\Bobra\Cpa\LoanGate\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\LoanGate\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const AFCLICK = 'afclick';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        if (!array_key_exists(static::AFCLICK, $query)) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::LOAN_GATE,
            ['afclick' => $query[static::AFCLICK],]
        );
    }
}
