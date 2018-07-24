<?php

namespace Wearesho\Bobra\Cpa\FinLine;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\FinLine
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $clickId;

    public function rules(): array
    {
        return [
            [['clickId',], 'required',],
            [['clickId',], 'string',],
        ];
    }
}
