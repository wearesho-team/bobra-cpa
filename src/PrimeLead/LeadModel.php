<?php

namespace Wearesho\Bobra\Cpa\PrimeLead;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\PrimeLead
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $transactionId;

    public function rules(): array
    {
        return [
            ['transactionId', 'required',],
            ['transactionId', 'string',],
        ];
    }
}
