<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\LinkProfit\Lead\Parser;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit
 */
class LeadParserTest extends AbstractTestCase
{
    public function testMissingWmId(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse(''));
    }

    public function testMissingClickHash(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?wm_id=test'));
    }

    public function testMissingUtmSource(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?wm_id=test&click_hash=test'));
    }

    public function testInvalidUtmSource(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?wm_id=test&click_hash=test&utm_source=invalid'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?wm_id=test&click_hash=test&utm_source=linkprofit');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('linkProfit', $info->getSource());
        $this->assertEquals([
            'clickHash' => 'test',
            'refId' => 'test',
        ], $info->getConfig());
    }
}
