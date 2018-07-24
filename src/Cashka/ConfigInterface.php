<?php

namespace Wearesho\Bobra\Cpa\Cashka;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\Cashka
 */
interface ConfigInterface
{
    public function getPath(?string $product = null): string;
}
