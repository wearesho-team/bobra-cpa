<?php

namespace Wearesho\Bobra\Cpa\Tests\PrimeLead;

use Wearesho\Bobra\Cpa;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTestCase
 * @package Wearesho\Bobra\Cpa\Tests\PrimeLead
 * @internal
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\PrimeLead\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\PrimeLead\LeadModel();
    }

    public function testMissingTransactionId(): void
    {
        $this->model->transactionId = null;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('transactionId', $this->model->firstErrors);
    }

    public function testIntegerTransactionId(): void
    {
        $this->model->transactionId = 1;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('transactionId', $this->model->firstErrors);
    }

    public function testCorrectTransactionId(): void
    {
        $this->model->transactionId = 'correctTransactionId';

        $this->assertTrue($this->model->validate());
    }
}
