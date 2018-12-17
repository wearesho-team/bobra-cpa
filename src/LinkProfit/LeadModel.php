<?php

namespace Wearesho\Bobra\Cpa\LinkProfit;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\LinkProfit
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $clickHash;

    /** @var string */
    public $refId;

    public function rules(): array
    {
        return [
            [
                ['clickHash', 'refId',],
                'required',
            ],
            [
                ['clickHash', 'refId',],
                'string',
            ],
        ];
    }
}
