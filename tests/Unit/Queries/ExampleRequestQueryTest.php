<?php

namespace Horat1us\Package\Tests\Queries;

use Horat1us\Package\Records\ExampleRecord;
use Horat1us\Package\Tests\AbstractTestCase;
use Horat1us\Package\Tests\Fixtures\ExampleRecordFixture;

/**
 * Class ExampleRequestQueryTest
 * @package Horat1us\Package\Tests\Queries
 *
 * @internal
 */
class ExampleRequestQueryTest extends AbstractTestCase
{
    public function fixtures()
    {
        return [
            ExampleRecordFixture::class,
        ];
    }

    public function testWhereText()
    {
        $record = ExampleRecord::find()->one();
        $found = ExampleRecord::find()->whereTextLike($record->text)->one();


        $this->assertInstanceOf(ExampleRecord::class, $found);
        $this->assertEquals($record->text, $found->text);
    }
}
