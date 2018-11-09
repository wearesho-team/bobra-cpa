<?php

namespace Wearesho\Bobra\Cpa\Lead;

use yii\base;

/**
 * Class ParsersChain
 * @package Wearesho\Bobra\Cpa\Lead
 */
class ParsersChain extends base\BaseObject implements ParserInterface
{
    /** @var ParserInterface[] */
    public $parsers = [];

    public function parse(string $url): ?LeadInfo
    {
        foreach ($this->parsers as $parser) {
            $leadInfo = $parser->parse($url);
            if ($leadInfo instanceof LeadInfo) {
                return $leadInfo;
            }
        }

        return null;
    }
}
