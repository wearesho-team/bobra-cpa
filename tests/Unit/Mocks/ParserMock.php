<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Mocks;

use Wearesho\Bobra\Cpa\Lead;

/**
 * Class ParserMock
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Mocks
 */
class ParserMock implements Lead\Parser
{
    /** @var bool */
    protected $isSuccessful;

    public function __construct(bool $isSuccessful = true)
    {
        $this->isSuccessful = $isSuccessful;
    }

    public function parse(string $url): ?Lead\Info
    {
        return $this->isSuccessful
            ? new Lead\Info('test', ['testField' => 'testValue',])
            : null;
    }
}
