<?php

namespace Wearesho\Bobra\Cpa\LinkProfit;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\LinkProfit
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
        $query = [
            'OrderID' => $conversion->getId(),
            'ClickHash' => $conversion->getConfig()['clickHash'] ?? '',
            'CampaignID' => $this->config->getCampaignId($conversion->getProduct()),
            'AffiliateID' => $conversion->getConfig()['refId'] ?? '',
        ];

        $url = ConfigInterface::URL . '?' . http_build_query($query);

        return new Psr7\Request("GET", $url);
    }
}
