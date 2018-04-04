<?php

namespace Wearesho\Bobra\Cpa\Services;

use yii\base\BaseObject;

use Psr\Http\Message\RequestInterface;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

use Wearesho\Bobra\Cpa\Interfaces\ConversionSenderInterface;
use Wearesho\Bobra\Cpa\Entities\PostbackTuple;

/**
 * Class AbstractSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
abstract class AbstractSendService extends BaseObject implements ConversionSenderInterface
{
    /** @var ClientInterface */
    protected $client;

    public function __construct(ClientInterface $client, array $config = [])
    {
        parent::__construct($config);
        $this->client = $client;
    }

    final public function send(string $conversion, array $params): PostbackTuple
    {
        $request = $this->getRequest($conversion, $params);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            return new PostbackTuple($request, $e->getResponse());
        } catch (GuzzleException $e) {
            return new PostbackTuple($request);
        }

        return new PostbackTuple($request, $response);
    }

    abstract protected function getRequest(string $conversion, array $params): RequestInterface;
}
