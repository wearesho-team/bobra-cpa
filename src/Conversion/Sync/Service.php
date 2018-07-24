<?php

namespace Wearesho\Bobra\Cpa\Conversion\Sync;

use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa;
use yii\di;
use yii\helpers;

/**
 * Class Service
 * @package Wearesho\Bobra\Cpa\Conversion
 */
class Service implements Cpa\Conversion\ServiceInterface
{
    /** @var array[]|string[]|Cpa\Conversion\SendServiceInterface[] definitions */
    public $senders = [
        Cpa\Lead\Source::DO_AFFILIATE => [
            'class' => Cpa\DoAffiliate\SendService::class,
            'config' => [
                'class' => Cpa\DoAffiliate\EnvironmentConfig::class,
            ],
        ],
        Cpa\Lead\Source::LEADS_SU => [
            'class' => Cpa\LeadsSu\SendService::class,
            'config' => [
                'class' => Cpa\LeadsSu\EnvironmentConfig::class,
            ],
        ],
    ];

    /**
     * @param Cpa\Lead $lead
     * @param string $conversionId
     * @throws \yii\base\InvalidConfigException
     * @throws \Horat1us\Yii\Interfaces\ModelExceptionInterface
     */
    public function register(Cpa\Lead $lead, string $conversionId): void
    {
        $source = $lead->source;
        if (!array_key_exists($source, $this->senders)) {
            $source = lcfirst(helpers\Inflector::id2camel($source));
            \Yii::debug("Trying to send conversion with id case sender", static::class);
        }

        if (!array_key_exists($source, $this->senders)) {
            \Yii::info("Trying to send conversion through disabled sender: $source", static::class);
            return;
        }

        $conversion = new Cpa\Conversion();
        $conversion->lead = $lead;
        $conversion->conversion_id = $conversionId;

        if ($conversion->isExists()) {
            \Yii::info("Skipping sending duplicate conversion {$conversionId}", static::class);
            return;
        }

        /** @var Cpa\Conversion\SendServiceInterface $sender */
        $sender = di\Instance::ensure($this->senders[$source], Cpa\Conversion\SendServiceInterface::class);
        $result = $sender->send($conversion);

        $conversion->request = [
            'method' => $result->getRequest()->getMethod(),
            'uri' => (string)$result->getRequest()->getUri(),
            'body' => $result->getRequest()->getBody()->getContents(),
        ];

        $response = $result->getResponse();
        if (!is_null($response)) {
            $conversion->response = [
                'code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
            ];
        } else {
            \Yii::error("Response for conversion $conversionId does not formed well.", static::class);
        }

        \Yii::info("Conversion $conversionId sent.", static::class);

        ModelException::saveOrThrow($conversion);
    }
}
