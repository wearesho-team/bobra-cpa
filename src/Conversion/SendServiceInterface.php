<?php

namespace Wearesho\Bobra\Cpa\Conversion;

use Wearesho\Bobra\Cpa;

/**
 * Interface SendServiceInterface
 * @package Wearesho\Bobra\Cpa\Conversion
 *
 * This interface is responsible for sending postbacks for registered conversions
 */
interface SendServiceInterface
{
    public function send(Cpa\ConversionInterface $conversion): Cpa\PostbackTuple;
}
