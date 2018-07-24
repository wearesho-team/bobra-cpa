<?php

namespace Wearesho\Bobra\Cpa;

use Psr\Http\Message;

/**
 * Class PostbackTuple
 * @package Wearesho\Bobra\Cpa
 */
class PostbackTuple
{
    /** @var Message\RequestInterface */
    protected $request;

    /** @var Message\ResponseInterface */
    protected $response;

    public function __construct(Message\RequestInterface $request, Message\ResponseInterface $response = null)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Message\ResponseInterface
     */
    public function getResponse(): ?Message\ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return Message\RequestInterface
     */
    public function getRequest(): Message\RequestInterface
    {
        return $this->request;
    }
}
