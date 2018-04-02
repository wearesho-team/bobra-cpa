<?php

namespace Wearesho\Bobra\Cpa\Services;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class LoanGateSendService
 * @package Wearesho\Bobra\Cpa\Services
 */
class LoanGateSendService extends AbstractSendService
{
    const ENV_GOAL_KEY = 'LOAN_GATE_GOAL';
    const ENV_SECURE_KEY = 'LOAN_GATE_SECURE';

    /** @var int */
    public $goal;

    /** @var string */
    public $secure;

    protected function getRequest(string $conversion, array $params): RequestInterface
    {
        $clickId = $params['afclick'] ?? null;
        $url = "http://offers.loangate.affise.com/postback?clickid={$clickId}&action_id={$conversion}&goal={$this->goal}&secure={$this->secure}";
        return new Request("get", $url);
    }

    public function isEnabled(): bool
    {
        return !is_null($this->goal) && !empty($this->secure);
    }
}
