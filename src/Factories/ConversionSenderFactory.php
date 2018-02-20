<?php

namespace Wearesho\Bobra\Cpa\Factories;

use Wearesho\Bobra\Cpa\Interfaces\ConversionSenderInterface;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Bobra\Cpa\Services\SalesDoublerSendService;
use yii\di\Instance;

/**
 * Class ConversionSenderFactory
 * @package Wearesho\Bobra\Cpa\Factories
 */
class ConversionSenderFactory
{
    public function senders()
    {
        return [
            UserLead::SOURCE_SALES_DOUBLER => [
                'class' => SalesDoublerSendService::class,
                'token' => getenv(SalesDoublerSendService::ENV_TOKEN_KEY),
            ],
        ];
    }

    public function instantiate(string $source): ConversionSenderInterface
    {
        $senders = $this->senders();
        if (!array_key_exists($source, $senders)) {
            throw new \InvalidArgumentException("Can not instantiate sender for $source");
        }

        return Instance::ensure($senders[$source], ConversionSenderInterface::class);
    }
}
