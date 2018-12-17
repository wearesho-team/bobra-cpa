<?php

namespace Wearesho\Bobra\Cpa\Lead\Parser;

/**
 * Trait QueryParams
 * @package Wearesho\Bobra\Cpa\Lead\Parser
 */
trait QueryParams
{
    /**
     * @param string $url
     * @return array        Associative array where key is the name of query param and value is its value
     *                      'https://test.com?a=b&c=d' => ['a' => 'b', 'c' => 'd',]
     */
    protected function getQueryParams(string $url): array
    {
        $queryString = parse_url($url, PHP_URL_QUERY) ?? '';
        parse_str($queryString, $output);
        return $output;
    }
}
