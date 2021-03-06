<?php

namespace Wearesho\Bobra\Cpa\Lead\Parser;

use Wearesho\Bobra\Cpa;
use Wearesho\Bobra\Cpa\Lead;
use yii\base;
use yii\di;

/**
 * Class Chain
 * @package Wearesho\Bobra\Cpa\Lead
 */
class Chain extends base\BaseObject implements Lead\Parser
{
    /** @var array[]|string[]|Lead\Parser[] */
    public $parsers = [
        Cpa\AdmitAd\Lead\Parser::class,
        Cpa\Cashka\Lead\Parser::class,
        Cpa\DoAffiliate\Lead\Parser::class,
        Cpa\FinLine\Lead\Parser::class,
        Cpa\LeadGid\Lead\Parser::class,
        Cpa\LeadsSu\Lead\Parser::class,
        Cpa\Letmeads\Lead\Parser::class,
        Cpa\LoanGate\Lead\Parser::class,
        Cpa\PrimeLead\Lead\Parser::class,
        Cpa\SalesDoubler\Lead\Parser::class,
    ];

    public function init(): void
    {
        parent::init();
        $this->parsers = array_map(function ($parser): Lead\Parser {
            return di\Instance::ensure($parser, Lead\Parser::class);
        }, $this->parsers);
    }

    public function parse(string $url): ?Lead\Info
    {
        foreach ($this->parsers as $parser) {
            $leadInfo = $parser->parse($url);
            if ($leadInfo instanceof Lead\Info) {
                return $leadInfo;
            }
        }

        return null;
    }
}
