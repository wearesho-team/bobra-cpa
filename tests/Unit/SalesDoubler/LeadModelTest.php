<?php

namespace Wearesho\Bobra\Cpa\Tests\SalesDoubler;

use Wearesho\Bobra\Cpa;
use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\SalesDoubler
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\SalesDoubler\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\SalesDoubler\LeadModel();
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

    public function testInvalidAid(): void
    {
        $this->model->clickId = 'correctClickId';
        $this->model->aid = 123;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('aid', $this->model->firstErrors);
    }
}
