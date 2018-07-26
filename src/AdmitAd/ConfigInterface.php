<?php

namespace Wearesho\Bobra\Cpa\AdmitAd;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\AdmitAd
 */
interface ConfigInterface
{
    public function getPostbackKey(?string $product = null): string;

    public function getCampaignCode(?string $product = null): string;

    public function getActionCode(?string $product = null): int;
}
