<?php

namespace Wearesho\Bobra\Cpa\DoAffiliate;

use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use GuzzleHttp;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\DoAffiliate
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
        $visitor = $conversion->getConfig()['visitor'] ?? null;
        $user = $conversion->getUser();

        $params = [
            'type' => 'CPA',
            'lead' => $user,
            'sale' => $conversion->getId(),
            'v' => $visitor,
        ];

        $path = $this->config->getPath($conversion->getProduct());
        $url = "http://tracker2.doaffiliate.net/api/{$path}?"
            . http_build_query($params);

        return new GuzzleHttp\Psr7\Request('get', $url);
    }
}
