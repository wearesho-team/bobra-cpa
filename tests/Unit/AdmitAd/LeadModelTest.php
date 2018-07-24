<?php

namespace Wearesho\Bobra\Cpa\Tests\AdmitAd;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\AdmitAd
 */
class LeadModelTest extends TestCase
{
    /** @var Cpa\AdmitAd\LeadModel */
    protected $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Cpa\AdmitAd\LeadModel();
    }

    public function testMissingUid(): void
    {
        $this->model->uid = null;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('uid', $this->model->firstErrors);
    }

    public function testIntegerUid(): void
    {
        $this->model->uid = 1;

        $this->assertFalse($this->model->validate());
        $this->assertArrayHasKey('uid', $this->model->firstErrors);
    }

    public function testCorrectUid(): void
    {
        $this->model->uid = 'askdj12';

        $this->assertTrue($this->model->validate());
    }
}
