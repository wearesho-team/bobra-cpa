<?php

namespace Wearesho\Bobra\Cpa\LeadGid;

use GuzzleHttp;
use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\LeadGid
 */
class SendService extends base\BaseObject implements Cpa\Conversion\SendServiceInterface
{
    use Cpa\Conversion\SendServiceTrait;

    /** @var array|string|ConfigInterface */
    public $config = [
        'class' => EnvironmentConfig::class,
    ];

    public function init(): void
    {
        parent::init();
        $this->config = di\Instance::ensure($this->config, ConfigInterface::class);
    }

    protected function getRequest(Cpa\ConversionInterface $conversion): RequestInterface
    {
        $params = [
            'offer_id' => $this->config->getOfferId($conversion->getProduct()),
            'adv_sub' => $conversion->getId(),
            'transaction_id' => $conversion->getConfig()['clickId'] ?? null,
        ];

        $url = 'http://go.leadgid.ru/aff_lsr?'
            . http_build_query($params);

        return new GuzzleHttp\Psr7\Request('get', $url);
    }
}
