<?php

namespace Wearesho\Bobra\Cpa\Letmeads;

/**
 * Interface ConfigInterface
 * @package Wearesho\Bobra\Cpa\Letmeads
 */
interface ConfigInterface
{
    public function getPath(?string $product): string;

    public function getRef(?string $product): string;
}
