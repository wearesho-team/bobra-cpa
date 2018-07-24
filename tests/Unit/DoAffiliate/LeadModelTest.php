<?php

namespace Wearesho\Bobra\Cpa\Tests\DoAffiliate;

use Wearesho\Bobra\Cpa;
use yii\phpunit\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\DoAffiliate
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\DoAffiliate\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\DoAffiliate\LeadModel();
    }

    public function testMissingVisitor(): void
    {
        $this->model->visitor = null;
        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('visitor', $this->model->firstErrors);
    }

    public function testInvalidVisitor(): void
    {
        $this->model->visitor = 1;
        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('visitor', $this->model->firstErrors);
    }

    public function testValid(): void
    {
        $this->model->visitor = '123';
        $this->assertTrue($this->model->validate());
    }
}
