<?php

namespace Wearesho\Bobra\Cpa\Conversion;

use Wearesho\Bobra\Cpa;

/**
 * Interface ServiceInterface
 * @package Wearesho\Bobra\Cpa\Conversion
 */
interface ServiceInterface
{
    public function register(Cpa\Lead $lead, string $conversionId): void;
}
