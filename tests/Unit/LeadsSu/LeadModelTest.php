<?php

namespace Wearesho\Bobra\Cpa\Tests\LeadsSu;

use Wearesho\Bobra\Cpa;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\LeadsSu
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\LeadsSu\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\LeadsSu\LeadModel();
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

    public function testIncorrectTransactionIdLength(): void
    {
        $this->model->transactionId = str_repeat('a', 31);

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('transactionId', $this->model->firstErrors);
    }

    public function testCorrectTransactionId(): void
    {
        $this->model->transactionId = str_repeat('b', 32);

        $this->assertTrue($this->model->validate());
    }
}
