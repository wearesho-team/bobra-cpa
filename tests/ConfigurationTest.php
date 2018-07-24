<?php

namespace Wearesho\Bobra\Cpa\Tests;

use PHPUnit\Framework\TestCase;
use Wearesho\Bobra\Cpa;
use yii\base\Module;
use yii\web\User;

/**
 * Class ConfigurationTest
 * @package Wearesho\Bobra\Cpa\Tests
 */
class ConfigurationTest extends TestCase
{
    public function testSameConversionAndLeadServices(): void
    {
        $conversionService = new Cpa\Conversion\Sync\Service();
        $leadController = new Cpa\Web\Controller('id', new Module('id'), [
            'user' => new class extends User
            {
                public $enableSession = false;

                public function init(): void
                {
                }
            },
        ]);

        foreach ($conversionService->senders as $senderName => $config) {
            $this->assertArrayHasKey($senderName, $leadController->sources);
        }
    }
}
