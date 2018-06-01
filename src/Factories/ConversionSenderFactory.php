<?php

namespace Wearesho\Bobra\Cpa\Factories;

use Wearesho\Bobra\Cpa\Interfaces\ConversionSenderInterface;
use Wearesho\Bobra\Cpa\Records\UserLead;
use Wearesho\Bobra\Cpa\Services\AdmitAdSendService;
use Wearesho\Bobra\Cpa\Services\CashkaSendService;
use Wearesho\Bobra\Cpa\Services\DoAffiliateSendService;
use Wearesho\Bobra\Cpa\Services\FinLineSendService;
use Wearesho\Bobra\Cpa\Services\LoanGateSendService;
use Wearesho\Bobra\Cpa\Services\PrimeLeadSendService;
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
                'id' => getenv(SalesDoublerSendService::ENV_TOKEN_ID),
                'token' => getenv(SalesDoublerSendService::ENV_TOKEN_KEY),
            ],
            UserLead::SOURCE_LOAN_GATE => [
                'class' => LoanGateSendService::class,
                'goal' => getenv(LoanGateSendService::ENV_GOAL_KEY) ?: 1,
                'secure' => getenv(LoanGateSendService::ENV_SECURE_KEY),
            ],
            UserLead::SOURCE_DO_AFFILIATE => [
                'class' => DoAffiliateSendService::class,
                'path' => getenv(DoAffiliateSendService::ENV_PATH_KEY),
            ],
            UserLead::SOURCE_FIN_LINE => FinLineSendService::class,
            UserLead::SOURCE_CASHKA => [
                'class' => CashkaSendService::class,
                'path' => getenv(CashkaSendService::ENV_PATH_KEY),
            ],
            UserLead::SOURCE_ADMIT_AD => [
                'class' => AdmitAdSendService::class,
                'campaignCode' => getenv(AdmitAdSendService::ENV_CAMPAIGN_CODE),
                'postbackKey' => getenv(AdmitAdSendService::ENV_POSTBACK_KEY),
            ],
            UserLead::SOURCE_PRIME_LEAD => [
                'class' => PrimeLeadSendService::class,
                'path' => getenv(PrimeLeadSendService::ENV_PATH_KEY),
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
