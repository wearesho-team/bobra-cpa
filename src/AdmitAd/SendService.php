<?php

namespace Wearesho\Bobra\Cpa\AdmitAd;

use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\AdmitAd
 */
class SendService extends base\BaseObject implements Cpa\Conversion\SendServiceInterface
{
    use Cpa\Conversion\SendServiceTrait;

    /** @var array|string|ConfigInterface definition */
    public $config = [
        'class' => EnvironmentConfig::class,
    ];

    /**
     * @throws base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->config = di\Instance::ensure($this->config, ConfigInterface::class);
    }

    protected function getRequest(Cpa\ConversionInterface $conversion): RequestInterface
    {
        $uid = $conversion->getConfig()['uid'] ?? null;

        $params = [
            'campaign_code' => $this->config->getCampaignCode($conversion->getProduct()),
            'postback' => 1,
            'postback_key' => $this->config->getPostbackKey($conversion->getProduct()),
            'action_code' => 2,
            'uid' => $uid,
            'order_id' => $conversion->getId(),
            'tariff_code' => 1,
            'payment_type' => 'sale',
        ];

        return new Psr7\Request(
            'get',
            "https://ad.admitad.com/r?" . http_build_query($params)
        );
    }
}
