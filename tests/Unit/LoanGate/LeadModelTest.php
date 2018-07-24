<?php

namespace Wearesho\Bobra\Cpa\Tests\LoanGate;

use Wearesho\Bobra\Cpa;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\LoanGate
 * @internal
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\LoanGate\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\LoanGate\LeadModel();
    }

    public function testMissingAfclick(): void
    {
        $this->model->afclick = null;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('afclick', $this->model->firstErrors);
    }

    public function testIntegerAfclick(): void
    {
        $this->model->afclick = 1;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('afclick', $this->model->firstErrors);
    }

    public function testCorrectAfclick(): void
    {
        $this->model->afclick = 'correctAfclick';

        $this->assertTrue($this->model->validate());
    }
}
