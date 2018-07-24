<?php

namespace Wearesho\Bobra\Cpa\SalesDoubler;

use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use GuzzleHttp\Psr7;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\SalesDoubler
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
        $clickId = $conversion->getConfig()['clickId'] ?? null;
        $transId = $conversion->getId();
        $token = $this->config->getToken($conversion->getProduct());
        $id = $this->config->getId($conversion->getProduct());

        $url = "http://rdr.salesdoubler.com.ua/in/postback/{$id}/{$clickId}?trans_id={$transId}&token={$token}";

        return new Psr7\Request('get', $url);
    }
}
