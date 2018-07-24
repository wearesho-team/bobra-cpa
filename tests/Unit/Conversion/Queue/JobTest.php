<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Conversion\Queue;

use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa;
use yii\queue;

/**
 * Class JobTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Conversion\Queue
 */
class JobTest extends Cpa\Tests\AbstractTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Lead 0 does not exist!
     */
    public function testInvalidLeadId(): void
    {
        $job = new Cpa\Conversion\Queue\Job(0, 'conversionId');
        $job->execute(new queue\sync\Queue);
    }

    public function testExecution(): void
    {
        $this->container->set(
            Cpa\Conversion\Sync\Service::class,
            $syncMock = new class extends Cpa\Conversion\Sync\Service
            {
                /** @var Cpa\Lead */
                public $lead;

                /** @var string */
                public $conversionId;

                public function register(Cpa\Lead $lead, string $conversionId): void
                {
                    $this->lead = $lead;
                    $this->conversionId = $conversionId;
                }
            }
        );

        $lead = new Cpa\Lead([
            'source' => 'test',
            'config' => [
                'key' => 'value',
            ],
            'user_id' => 1,
            'product' => null,
        ]);
        ModelException::saveOrThrow($lead);

        $job = new Cpa\Conversion\Queue\Job($lead->id, 'conversionTest');
        $job->execute(new queue\sync\Queue);

        $this->assertEquals($lead->toArray(), $syncMock->lead->toArray());
        $this->assertEquals('conversionTest', $syncMock->conversionId);

        $lead->delete();
    }

    public function testSleep(): void
    {
        $job = new Cpa\Conversion\Queue\Job(1, 'conversionId');
        $this->assertEquals(
            1,
            $job->leadId
        );
        $this->assertEquals(
            'conversionId',
            $job->conversionId
        );

        $serialized = serialize($job);
        /** @var Cpa\Conversion\Queue\Job $unserializedJob */
        $unserializedJob = unserialize($serialized);

        $this->assertEquals(
            $job->leadId,
            $unserializedJob->leadId
        );
        $this->assertEquals(
            $job->conversionId,
            $unserializedJob->conversionId
        );
    }
}
