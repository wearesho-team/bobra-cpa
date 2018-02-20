<?php

namespace Horat1us\Package\Tests\Unit\Records;

use Horat1us\Package\Records\ExampleRecord;
use Horat1us\Package\Tests\AbstractTestCase;
use Horat1us\Package\Tests\Fixtures\ExampleRecordFixture;

/**
 * Class ExampleRecordTest
 * @package Horat1us\Package\Tests\Unit\Records
 *
 * @internal
 */
class ExampleRecordTest extends AbstractTestCase
{
    public function fixtures()
    {
        return [
            ExampleRecordFixture::class,
        ];
    }

    public function testFind()
    {
        $record = ExampleRecord::find()
            ->one();

        $this->assertInstanceOf(ExampleRecord::class, $record);
        $this->seeRecord(ExampleRecord::class, ['id' => $record->id,]);
    }

    public function testValidation()
    {
        $record = new ExampleRecord();
        $record->text = null;

        $this->assertFalse($record->validate());

        $record->text = mt_rand();
        $this->assertFalse($record->validate());

        $record->text = "SomeString";
        $this->assertTrue($record->validate());
    }
}
