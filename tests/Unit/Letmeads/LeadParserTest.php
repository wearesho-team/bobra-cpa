<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Letmeads;

use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\Letmeads\Lead\Parser;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Letmeads
 */
class LeadParserTest extends AbstractTestCase
{
    public function testMissingRef(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse(''));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('?letmeads_ref=1337');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('letmeads', $info->getSource());
        $this->assertEquals(['letmeadsRef' => 1337,], $info->getConfig());
    }
}
