<?php

namespace Wearesho\Bobra\Cpa\Entities;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PostbackTuple
 * @package Wearesho\Bobra\Cpa\Entities
 */
class PostbackTuple
{
    /** @var RequestInterface */
    protected $request;

    /** @var ResponseInterface */
    protected $response;

    public function __construct(RequestInterface $request, ResponseInterface $response = null)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ?ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
