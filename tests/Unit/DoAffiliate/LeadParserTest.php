<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\DoAffiliate;

use Wearesho\Bobra\Cpa\DoAffiliate\Lead\Parser;
use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\DoAffiliate
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

    public function testMissingVisitor(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?utm_source=doaff'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?utm_source=doaff&v=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('doAffiliate', $info->getSource());
        $this->assertEquals(['visitor' => 1337,], $info->getConfig());
    }
}
