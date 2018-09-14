<?php

namespace Wearesho\Bobra\Cpa\LeadGid;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\LeadGid
 */
interface ConfigInterface
{
    public function getOfferId(string $product = null): string;
}
