<?php

namespace Wearesho\Bobra\Cpa\LeadsSu;

use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Wearesho\Bobra\Cpa;
use yii\base;
use yii\di;

/**
 * Class SendService
 * @package Wearesho\Bobra\Cpa\LeadsSu
 */
class SendService extends base\BaseObject implements Cpa\Conversion\SendServiceInterface
{
    use Cpa\Conversion\SendServiceTrait;

    protected const STATUS_REJECTED = 'rejected';
    protected const STATUS_PENDING = 'pending';
    protected const STATUS_APPROVED = 'approved';

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

        $params = [
            'token' => $this->config->getToken($conversion->getProduct()),
            'goal_id' => 0,
            'transaction_id' => $transactionId,
            'adv_sub' => $conversion->getId(),
            'status' => static::STATUS_APPROVED,
            'comment' => 'undefined',
        ];

        $url = "http://api.leads.su/advertiser/conversion/createUpdate?" . http_build_query($params);
        return new Psr7\Request("post", $url);
    }
}
