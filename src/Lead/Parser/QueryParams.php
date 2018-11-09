<?php

namespace Wearesho\Bobra\Cpa\Lead\Parser;

/**
 * Trait QueryParams
 * @package Wearesho\Bobra\Cpa\Lead\Parser
 */
trait QueryParams
{
    protected function getQueryParams(string $url): array
    {
        $queryString = parse_url($url)['query'] ?? '';
        $query = [];

        foreach (explode('&', $queryString) as $paramPair) {
            $params = explode('=', $paramPair);
            if (count($params) < 2) {
                continue;
            }

            $query[$params[0]] = $params[1];
        }

        return $query;
    }
}
