<?php

namespace Wearesho\Bobra\Cpa\Conversion\Queue;

use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;
use yii\queue\Queue;

/**
 * Class Service
 * @package Wearesho\Bobra\Cpa\Conversion\Queue
 */
class Service extends base\BaseObject implements Cpa\Conversion\ServiceInterface
{
    /** @var string|array|Queue */
    public $queue = 'queue';

    /**
     * @throws base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->queue = di\Instance::ensure($this->queue, Queue::class);
    }

    public function register(Cpa\Lead $lead, string $conversionId): void
    {
        if ($lead->isNewRecord) {
            throw new \InvalidArgumentException("Can not put not saved " . Cpa\Lead::class . " into Queue");
        }

        $jobId = $this->queue->push(new Job($lead->id, $conversionId));
        \Yii::info(
            Job::class . " {$jobId} created for lead {$lead->id} with conversion {$conversionId}",
            static::class
        );
    }
}
