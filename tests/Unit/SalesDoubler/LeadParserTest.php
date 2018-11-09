<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\SalesDoubler;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\SalesDoubler\Lead\Parser;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\SalesDoubler
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

    public function testMissingTransactionId(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('?utm_source=salesdoubler'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?utm_source=salesdoubler&aff_sub=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('salesDoubler', $info->getSource());
        $this->assertEquals(['clickId' => 1337, 'aid' => null,], $info->getConfig());

        $info = $parser->parse('?utm_source=cpanet_salesdoubler&aff_sub=1337&utm_campaign=123');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('salesDoubler', $info->getSource());
        $this->assertEquals(['clickId' => 1337, 'aid' => 123,], $info->getConfig());

        $info = $parser->parse('?utm_source=cpanet_salesdubler&aff_sub=1337&aff_id=123');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('salesDoubler', $info->getSource());
        $this->assertEquals(['clickId' => 1337, 'aid' => 123,], $info->getConfig());
    }
}
