<?php

namespace Wearesho\Bobra\Cpa\Tests\Unit\Conversion\Queue;

use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa;
use yii\log\Logger;
use yii\queue;

/**
 * Class ServiceTest
 * @package Wearesho\Bobra\Cpa\Tests\Unit\Conversion\Queue
 */
class ServiceTest extends Cpa\Tests\AbstractTestCase
{
    /** @var queue\Queue */
    protected $queue;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->set('queue', $this->queue = new class extends queue\Queue
        {
            /** @var Cpa\Conversion\Queue\Job[] */
            protected $stack;

            protected function pushMessage($message, $ttr, $delay, $priority)
            {
                $this->stack[] = $message;
            }

            public function pop(): ?string
            {
                return array_pop($this->stack);
            }

            public function status($id)
            {
                return self::STATUS_WAITING;
            }
        });
    }

    public function testInit(): void
    {
        $service = new Cpa\Conversion\Queue\Service;
        $this->assertEquals($this->queue, $service->queue);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Can not put not saved Wearesho\Bobra\Cpa\Lead into Queue
     */
    public function testNotSavedLead(): void
    {
        $lead = new Cpa\Lead;
        $service = new Cpa\Conversion\Queue\Service;
        $service->register($lead, 'conversionId');
    }

    public function testRegister(): void
    {
        $lead = new Cpa\Lead([
            'user_id' => 1,
            'source' => 'test',
            'config' => [
                'key' => 'value',
            ],
            'product' => null,
        ]);

        $logger = new Logger();
        \Yii::setLogger($logger);

        ModelException::saveOrThrow($lead);

        $service = new Cpa\Conversion\Queue\Service;
        $service->register($lead, 'conversionId');

        $message = $this->queue->pop();

        /** @var Cpa\Conversion\Queue\Job $job */
        $job = unserialize($message);
        $this->assertInstanceOf(Cpa\Conversion\Queue\Job::class, $job);
        $this->assertEquals(
            $lead->id,
            $job->leadId
        );
        $this->assertEquals(
            'conversionId',
            $job->conversionId
        );

        $this->assertArraySubset(
            [
                Cpa\Conversion\Queue\Job::class . "  created for lead {$lead->id} with conversion conversionId",
                2 => Cpa\Conversion\Queue\Service::class,
            ],
            array_pop($logger->messages)
        );

        $lead->delete();
    }
}
