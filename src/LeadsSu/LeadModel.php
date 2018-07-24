<?php

namespace Wearesho\Bobra\Cpa\LeadsSu;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\LeadsSu
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $transactionId;

    public function rules(): array
    {
        return [
            [['transactionId',], 'required',],
            [['transactionId',], 'string', 'length' => 32,],
        ];
    }
}
