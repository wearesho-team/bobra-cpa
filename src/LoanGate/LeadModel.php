<?php

namespace Wearesho\Bobra\Cpa\LoanGate;

use yii\base;

/**
 * Class LeadModel
 * @package Wearesho\Bobra\Cpa\LoanGate
 */
class LeadModel extends base\Model
{
    /** @var string */
    public $afclick;

    public function rules(): array
    {
        return [
            [['afclick',], 'required',],
            [['afclick',], 'string',],
        ];
    }
}
