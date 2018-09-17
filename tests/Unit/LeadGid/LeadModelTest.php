<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LeadGid;

use Wearesho\Bobra\Cpa\LeadGid\LeadModel;

use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LeadGid
 * @coversDefaultClass LeadModel
 * @internal
 */
class LeadModelTest extends TestCase
{
    protected const ID = 'testId';

    /** @var LeadModel */
    protected $fakeLeadModel;

    protected function setUp(): void
    {
        $this->fakeLeadModel = new LeadModel();
    }

    public function testMissingClickId(): void
    {
        $this->fakeLeadModel->clickId = null;

        $this->assertFalse($this->fakeLeadModel->validate('clickId'));
        $this->assertArrayHasKey('clickId', $this->fakeLeadModel->firstErrors);
    }

    public function testCorrectClickId(): void
    {
        $this->fakeLeadModel->clickId = static::ID;

        $this->assertTrue($this->fakeLeadModel->validate('clickId'));
    }
}
