<?php

namespace Wearesho\Bobra\Cpa\Cashka;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\Cashka
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $transactionId;

    public function rules()
    {
        return [
            ['transactionId', 'required',],
            ['transactionId', 'string',],
        ];
    }
}
