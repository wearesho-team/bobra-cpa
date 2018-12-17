<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Lead;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\Lead\Parser\Chain;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;
use Wearesho\Bobra\Cpa\Tests\Unit\Mocks\ParserMock;

/**
 * Class ParserChainTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Lead
 */
class ParserChainTest extends AbstractTestCase
{
    public function testSuccessfulParsing(): void
    {
        $chain = new Chain([
            'parsers' => [new ParserMock(false)],
        ]);

        $this->assertNull($chain->parse(''));
    }

    public function testUnsuccessfulParsing(): void
    {
        $chain = new Chain([
            'parsers' => [ParserMock::class,],
        ]);

        $this->assertInstanceOf(Info::class, $chain->parse(''));
    }
}
