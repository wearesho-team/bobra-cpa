<?php

namespace Wearesho\Bobra\Cpa\DoAffiliate;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\DoAffiliate
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $visitor;

    public function rules(): array
    {
        return [
            [['visitor',], 'required',],
            [['visitor',], 'string',],
        ];
    }
}
