<?php

namespace Wearesho\Bobra\Cpa\Cashka;

use Wearesho\Bobra\Cpa;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\Cashka
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
        $transactionId = $conversion->getConfig()['transactionId'] ?? null;
        $path = $this->config->getPath($conversion->getProduct());

        return new Psr7\Request(
            "get",
            "http://track.cashka.com.ua/{$path}?adv_sub={$conversion->getId()}&transaction_id={$transactionId}"
        );
    }
}
