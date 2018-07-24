<?php

namespace Wearesho\Bobra\Cpa\Tests\FinLine;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\FinLine
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\FinLine\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\FinLine\LeadModel();
    }

    public function testMissingClickId(): void
    {
        $this->model->clickId = null;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('clickId', $this->model->firstErrors);
    }

    public function testIntegerClickId(): void
    {
        $this->model->clickId = 1;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('clickId', $this->model->firstErrors);
    }

    public function testCorrectClickId(): void
    {
        $this->model->clickId = 'askdj12';

        $this->assertTrue($this->model->validate());
    }
}
