<?php

namespace Wearesho\Bobra\Cpa\Lead;

/**
 * Interface Parser
 * @package Wearesho\Bobra\Cpa\Lead
 */
interface Parser
{
    public function parse(string $url) :?Info;
}
