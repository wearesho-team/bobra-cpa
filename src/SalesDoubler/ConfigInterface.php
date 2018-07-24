<?php

namespace Wearesho\Bobra\Cpa\SalesDoubler;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\SalesDoubler
 */
interface ConfigInterface
{
    public function getId(?string $product = null): int;

    public function getToken(?string $product = null): string;
}
