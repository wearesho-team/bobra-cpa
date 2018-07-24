<?php

namespace Wearesho\Bobra\Cpa\DoAffiliate;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\DoAffiliate
 */
interface ConfigInterface
{
    public function getPath(?string $product = null): string;
}
