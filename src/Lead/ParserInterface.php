<?php

namespace Wearesho\Bobra\Cpa\Lead;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Interface Parser
 * @package Wearesho\Bobra\Cpa\Lead
 */
interface ParserInterface
{
    public function parse(string $url) :?LeadInfo;
}
