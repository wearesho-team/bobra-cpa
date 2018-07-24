<?php

namespace Wearesho\Bobra\Cpa;

/**
 * Trait EnvironmentConfigTrait
 * @package Wearesho\Bobra\Cpa
 */
trait EnvironmentConfigTrait
{
    protected function appendProductPrefix(string $envKey, ?string $product = null): string
    {
        return $this->getProductPrefix($product) . $envKey;
    }

    protected function getProductPrefix(?string $product = null): string
    {
        if (is_null($product)) {
            return '';
        }
        return mb_strtoupper($product) . '_';
    }
}
