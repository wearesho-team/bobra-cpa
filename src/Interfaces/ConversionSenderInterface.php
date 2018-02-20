<?php

namespace Wearesho\Bobra\Cpa\Interfaces;

use Wearesho\Bobra\Cpa\Entities\PostbackTuple;

/**
 * Interface ConversionSenderInterface
 * @package Wearesho\Bobra\Cpa\Interfaces
 */
interface ConversionSenderInterface
{
    public function send(string $conversion, array $params): PostbackTuple;

    public function isEnabled(): bool;
}
