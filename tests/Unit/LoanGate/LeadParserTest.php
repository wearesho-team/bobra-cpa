<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LoanGate;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\LoanGate\Lead\Parser;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LoanGate
 */
class LeadParserTest extends AbstractTestCase
{
    public function testMissingParam(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse(''));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?afclick=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('loanGate', $info->getSource());
        $this->assertEquals(['afclick' => 1337,], $info->getConfig());
    }
}
