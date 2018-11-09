<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\AdmitAd;

use Wearesho\Bobra\Cpa\AdmitAd\Lead\Parser;
use Wearesho\Bobra\Cpa\Lead\Info;
use Wearesho\Bobra\Cpa\Tests\AbstractTestCase;

/**
 * Class LeadParserTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\AdmitAd
 */
class LeadParserTest extends AbstractTestCase
{
    public function testMissingKey(): void
    {
        $parser = new Parser();
        $this->assertNull($parser->parse('https://test.com?testParam=testValue'));
    }

    public function testSuccess(): void
    {
        $parser = new Parser();
        $info = $parser->parse('https://test.com?admitad_uid=test');
        $this->assertInstanceOf(Info::class, $info);
        $this->assertEquals('admitAd', $info->getSource());
        $this->assertEquals(['uid' => 'test',], $info->getConfig());
    }
}
