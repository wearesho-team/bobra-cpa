<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\FinLine;

use Wearesho\Bobra\Cpa\FinLine\Lead\Parser;
use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\FinLine
 */
class LeadParserTest extends AbstractTestCase
{
    public function testMissingUtmSource(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse(''));
    }

    public function testInvalidUtmSource(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?utm_source=invalid'));
    }

    public function testMissingClickId(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?utm_source=finline'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?utm_source=finline&clickid=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('finLine', $info->getSource());
        $this->assertEquals(['clickId' => 1337,], $info->getConfig());
    }
}
