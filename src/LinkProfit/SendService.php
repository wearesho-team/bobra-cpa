<?php

namespace Wearesho\Bobra\Cpa\LinkProfit;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\LinkProfit
 */
class SendService extends base\BaseObject implements Cpa\Conversion\SendServiceInterface
{
    /** @var array|string|ConfigInterface definition */
    public $config = [
        'class' => EnvironmentConfig::class,
    ];

    /** @var array|string|GuzzleHttp\ClientInterface definition */
    public $client = [
        'class' => GuzzleHttp\ClientInterface::class,
    ];

    /**
     * @throws base\InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->config = di\Instance::ensure($this->config, ConfigInterface::class);
    }

    protected function getInitialRequest(Cpa\ConversionInterface $conversion): RequestInterface
    {
        $query = [
            'OrderID' => $conversion->getId(),
            'ClickHash' => $conversion->getConfig()['clickHash'] ?? '',
            'CampaignID' => $this->config->getCampaignId($conversion->getProduct()),
            'AffiliateID' => $conversion->getConfig()['refId'] ?? '',
        ];

        $url = 'https://cpa.linkprofit.ru/sale?' . http_build_query($query);

        return new GuzzleHttp\Psr7\Request('GET', $url);
    }

    protected function getAdditionalRequest(Cpa\ConversionInterface $conversion): RequestInterface
    {
        $url = "http://s.linkprofit.ru/postback/{$conversion->getProduct()}/update/{$conversion->getId()}?Status=A";

        return new GuzzleHttp\Psr7\Request('GET', $url);
    }

    /**
     * @param Cpa\ConversionInterface $conversion
     * @return Cpa\PostbackTuple
     * @throws \yii\base\InvalidConfigException
     */
    final public function send(Cpa\ConversionInterface $conversion): Cpa\PostbackTuple
    {
        /** @var GuzzleHttp\ClientInterface $client */
        $client = di\Instance::ensure($this->client, GuzzleHttp\ClientInterface::class);
        $request = $this->getAdditionalRequest($conversion);

        try {
            $client->send($this->getInitialRequest($conversion));
            $response = $client->send($request);
        } catch (GuzzleHttp\Exception\RequestException $e) {
            return new Cpa\PostbackTuple($request, $e->getResponse());
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            return new Cpa\PostbackTuple($request);
        }

        return new Cpa\PostbackTuple($request, $response);
    }
}
