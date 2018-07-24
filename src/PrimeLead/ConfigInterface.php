<?php

namespace Wearesho\Bobra\Cpa\PrimeLead;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\PrimeLead
 */
interface ConfigInterface
{
    public function getPath(?string $product = null): string;
}
