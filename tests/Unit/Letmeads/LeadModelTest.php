<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Letmeads;

use Wearesho\Bobra\Cpa;

use PHPUnit\Framework\TestCase;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Letmeads
 * @internal
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\Letmeads\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\Letmeads\LeadModel();
    }

    public function testMissingIds(): void
    {
        $this->model->letmeadsRef = null;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('letmeadsRef', $this->model->firstErrors);
    }

    public function testIntegerIds(): void
    {
        $this->model->letmeadsRef = 1;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('letmeadsRef', $this->model->firstErrors);
    }

    public function testCorrectIds(): void
    {
        $this->model->letmeadsRef = 'correctLetmeadsRef';

        $this->assertTrue($this->model->validate());
    }
}
