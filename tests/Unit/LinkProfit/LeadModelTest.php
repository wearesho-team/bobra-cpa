<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa\LinkProfit\LeadModel;

/**
 * Class LeadModelTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\LinkProfit
 */
class LeadModelTest extends TestCase
{
    public function testGetAttributes(): void
    {
        $model = new LeadModel([
            'clickHash' => '123',
            'refId' => '123',
        ]);

        $this->assertTrue($model->validate());
    }
}
