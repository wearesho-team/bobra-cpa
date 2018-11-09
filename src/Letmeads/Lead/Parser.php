<?php

namespace Wearesho\Bobra\Cpa\Letmeads\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class Parser
 * @package Wearesho\Bobra\Cpa\Letmeads\Lead
 */
class Parser implements Lead\Parser
{
    use Lead\Parser\QueryParams;

    protected const REF = 'letmeads_ref';

    public function parse(string $url): ?Lead\Info
    {
        $query = $this->getQueryParams($url);

        if (!array_key_exists(static::REF, $query)) {
            return null;
        }

        return new Lead\Info(
            Lead\Source::LETMEADS,
            ['letmeadsRef' => $query[static::REF],]
        );
    }
}
