<?php

namespace Wearesho\Bobra\Cpa\LoanGate;

use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\LoanGate
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
        $clickId = $conversion->getConfig()['afclick'] ?? null;

        $params = [
            'clickid' => $clickId,
            'action_id' => $conversion->getId(),
            'goal' => $this->config->getGoal($conversion->getProduct()),
            'secure' => $this->config->getSecure($conversion->getProduct()),
        ];

        $url = "http://offers.loangate.affise.com/postback?" . http_build_query($params);
        return new Psr7\Request("get", $url);
    }
}
