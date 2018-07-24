<?php

namespace Wearesho\Bobra\Cpa\LeadsSu;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\LeadsSu
 */
interface ConfigInterface
{
    public function getToken(?string $product = null): string;
}
