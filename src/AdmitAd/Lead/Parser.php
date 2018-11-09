<?php

namespace Wearesho\Bobra\Cpa\AdmitAd\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class LeadParser
 * @package Wearesho\Bobra\Cpa\AdmitAd
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const PARAM_NAME = 'admitad_uid';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);
        if (empty($query) || !array_key_exists(static::PARAM_NAME, $query)) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::ADMIT_AD,
            ['uid' => $query[static::PARAM_NAME],]
        );
    }
}
