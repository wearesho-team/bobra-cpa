<?php

namespace Wearesho\Bobra\Cpa\Conversion\Queue;

use yii\queue;
use Wearesho\Bobra\Cpa;

/**
 * Class Job
 * @package Wearesho\Bobra\Cpa\Conversion\Queue
 */
class Job implements queue\JobInterface
{
    /** @var int */
    public $leadId;

    /** @var string */
    public $conversionId;

    public function __construct(int $leadId, string $conversionId)
    {
        $this->leadId = $leadId;
        $this->conversionId = $conversionId;
    }

    /**
     * @param queue\Queue $queue which pushed and is handling the job
     * @throws \Horat1us\Yii\Interfaces\ModelExceptionInterface
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function execute($queue): void
    {
        $lead = Cpa\Lead::findOne((int)$this->leadId);
        if (!$lead instanceof Cpa\Lead) {
            throw new \InvalidArgumentException("Lead {$this->leadId} does not exist!");
        }

        /** @var Cpa\Conversion\Sync\Service $service */
        $service = \Yii::$container->get(Cpa\Conversion\Sync\Service::class);
        $service->register($lead, $this->conversionId);
    }

    public function __sleep(): array
    {
        return ['leadId', 'conversionId'];
    }
}
