<?php

namespace Wearesho\Bobra\Cpa\LinkProfit;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\LinkProfit
 */
interface ConfigInterface
{
    public function getCampaignId(?string $product = null): string;
}
