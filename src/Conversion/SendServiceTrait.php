<?php

namespace Wearesho\Bobra\Cpa\Conversion;

use Wearesho\Bobra\Cpa;
use GuzzleHttp;
use Psr\Http\Message\RequestInterface;
use yii\di;

/**
 * Trait SendServiceTrait
 * @package Wearesho\Bobra\Cpa
 */
trait SendServiceTrait
{
    /** @var array|string|GuzzleHttp\ClientInterface definition */
    public $client = [
        'class' => GuzzleHttp\ClientInterface::class,
    ];

    /**
     * @param Cpa\ConversionInterface $conversion
     * @return Cpa\PostbackTuple
     * @throws \yii\base\InvalidConfigException
     */
    final public function send(Cpa\ConversionInterface $conversion): Cpa\PostbackTuple
    {
        /** @var GuzzleHttp\ClientInterface $client */
        $client = di\Instance::ensure($this->client, GuzzleHttp\ClientInterface::class);
        $request = $this->getRequest($conversion);

        try {
            $response = $client->send($request);
        } catch (GuzzleHttp\Exception\RequestException $e) {
            return new Cpa\PostbackTuple($request, $e->getResponse());
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            return new Cpa\PostbackTuple($request);
        }

        return new Cpa\PostbackTuple($request, $response);
    }

    abstract protected function getRequest(Cpa\ConversionInterface $conversion): RequestInterface;
}
