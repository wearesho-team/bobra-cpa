<?php

namespace Wearesho\Bobra\Cpa\Letmeads;

use GuzzleHttp\Psr7\Request;

use Psr\Http\Message\RequestInterface;

use Wearesho\Bobra\Cpa;

use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\Letmeads
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
        $path = $this->config->getPath($conversion->getProduct());

        $params = [
            'ref_id' => $conversion->getId(),
            'click_id' => $conversion->getConfig()['letmeadsRef']
                ?? $this->config->getRef($conversion->getProduct()),
        ];

        $url = "https://ad.letmeads.com/{$path}" . http_build_query($params);

        return new Request('get', $url);
    }
}
