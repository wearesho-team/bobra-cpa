<?php

namespace Wearesho\Bobra\Cpa\Lead;

use Horat1us\Yii\Exceptions\ModelException;
use Wearesho\Bobra\Cpa\Lead;
use yii\base;

/**
 * Class Service
 * @package Wearesho\Bobra\Cpa\Lead
 */
class Service extends base\BaseObject
{
    /** @var Lead\Parser */
    public $parser;

    public function __construct(Lead\Parser $parser, array $config = [])
    {
        parent::__construct($config);
        $this->parser = $parser;
    }

    /**
     * @param int $userId
     * @param string[] $urls
     * @throws \Horat1us\Yii\Interfaces\ModelExceptionInterface
     */
    public function create(int $userId, array $urls): void
    {
        foreach ($urls as $url) {
            $leadInfo = $this->parser->parse($url);
            if ($leadInfo instanceof Lead\Info) {
                break;
            }
        }

        if (empty($leadInfo)) {
            return;
        }

        $lead = new Lead([
            'source' => $leadInfo->getSource(),
            'config' => $leadInfo->getConfig(),
            'user_id' => $userId,
        ]);

        ModelException::saveOrThrow($lead);
    }
}
