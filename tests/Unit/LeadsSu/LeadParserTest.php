<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LeadsSu;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\LeadsSu\Lead\Parser;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LeadsSu
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
        $this->assertNull($parser->parse('?utm_source=leads-su'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?utm_source=leads-su&transaction_id=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('leadsSu', $info->getSource());
        $this->assertEquals(['transactionId' => 1337,], $info->getConfig());
    }
}
