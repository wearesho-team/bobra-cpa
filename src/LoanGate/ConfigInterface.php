<?php

namespace Wearesho\Bobra\Cpa\LoanGate;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\LoanGate
 */
interface ConfigInterface
{
    public function getGoal(?string $product = null): int;

    public function getSecure(?string $product = null): string;
}
